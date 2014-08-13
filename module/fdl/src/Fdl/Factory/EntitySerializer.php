<?php

/**
 * File : EntitySerializer.php
 * Created at 11-07-2014 6:16:22 PM
 * 
 * @author Corneliu Iancu - Opti Systems
 * @contact corneliu.iancu@opti.ro
 */

namespace Fdl\Factory;

use Doctrine\ORM\EntityManager;

class EntitySerializer {

	protected $em;

	public function __construct(EntityManager $em) {
		$this->em = $em;
	}

	public function serialize($entity) {
		$className = get_class($entity);

		$uow = $this->em->getUnitOfWork();
		$entityPersister = $uow->getEntityPersister($className);
		$classMetadata = $entityPersister->getClassMetadata();

		$result = array();
		foreach ($uow->getOriginalEntityData($entity) as $field => $value) {
			
			if (isset($classMetadata->associationMappings[$field])) {
				$assoc = $classMetadata->associationMappings[$field];

				// Only owning side of x-1 associations can have a FK column.
				if (!$assoc['isOwningSide'] || !($assoc['type'] & \Doctrine\ORM\Mapping\ClassMetadata::TO_ONE)) {
					continue;
				}

				if ($value !== null) {
					$newValId = $uow->getEntityIdentifier($value);
				}

				$targetClass = $this->em->getClassMetadata($assoc['targetEntity']);
				$owningTable = $entityPersister->getOwningTable($field);

				foreach ($assoc['joinColumns'] as $joinColumn) {
					$sourceColumn = $joinColumn['name'];
					$targetColumn = $joinColumn['referencedColumnName'];

					if ($value === null) {
						$result[$sourceColumn] = null;
					} else if ($targetClass->containsForeignIdentifier) {
						$result[$sourceColumn] = $newValId[$targetClass->getFieldForColumn($targetColumn)];
					} else {
						$result[$sourceColumn] = $newValId[$targetClass->fieldNames[$targetColumn]];
					}
				}
			} elseif (isset($classMetadata->columnNames[$field])) {
				$columnName = $classMetadata->columnNames[$field];
				$result[$columnName] = $value;
			}
		}
		
		return $result;
	}

	public function deserialize(Array $data) {
		list($class, $result) = $data;

		$uow = $this->em->getUnitOfWork();
		return $uow->createEntity($class, $result);
	}

}
