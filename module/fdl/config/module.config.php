<?php

return array(
	'doctrine' => array(
		'driver' => array(
			'application_entities' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/../src/Fdl/Entity')
			),
			'orm_default' => array(
				'drivers' => array(
					'Fdl\Entity' => 'application_entities'
				)
			)
		)
	),
	'controllers' => array(
		'invokables' => array(
			'Fdl\Controller\Fdl' => 'Fdl\Controller\FdlController',
		),
	),
	'router' => array(
		'routes' => array(
			'Fdl' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/fdl[/:action][/:id]',
					'constraints' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'Fdl\Controller\Fdl',
						'action' => 'index',
					),
				),
			),
		),
	),
	'view_manager' => array(
		'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
		'template_path_stack' => array(
			'fdl' => __DIR__ . '/../view',
		),
	),
	
);
