<?php
namespace Fdl;

// Add these import statements:
use Fdl\Model\Fdls;
use Fdl\Model\User;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


class Module
{
	
	// Add this method:
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
				'Fdl\Model\Fdls' =>  function($sm) {
					$entityManager = $sm->get('entityManager');
                    $instance = new Fdls($entityManager);
					return $instance;
                },
				'Fdl\Model\User' =>  function($sm) {
					$entityManager = $sm->get('entityManager');
                    $instance = new User($entityManager);
					return $instance;
                },
                'entityManager' => function ($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    return $em;
                },
            ),
        );
    }
	
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}