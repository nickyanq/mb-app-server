<?php

/**
 * File : Model.php
 * Created at 11-07-2014 4:39:22 PM
 * 
 * @author Corneliu Iancu - Opti Systems
 * @contact corneliu.iancu@opti.ro
 */

namespace Fdl\Model;

use Fdl\Factory\EntitySerializer;

class Model extends EntitySerializer{

	/** @var \Doctrine\ORM\EntityManager */
	protected $__em;
	
	protected static $connection = false;
			
	function __construct(\Doctrine\ORM\EntityManager $em) {
		
		parent::__construct($em);
				
				
		$this->__em = $this->getConnection($em);
	}
	
	private function getConnection($entityManager){
		if(!self::$connection){
			self::$connection = $entityManager;
		}
		return self::$connection;
	}

	//CODE TO BE CONTINUED...
	
}
