<?php

namespace Blog;

use Zend\ServiceManager\Factory\InvokableFactory;


return [
  'service_manager' => [
        'aliases' => [
            Model\PostRepositoryInterface::class => Model\ZendDbSqlRepository::class,
        ],
        'factories' => [
            Model\PostRepository::class => InvokableFactory::class,
            Model\ZendDbSqlRepository::class => Factory\ZendDbSqlRepositoryFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ListController::class => Factory\ListControllerFactory::class,
        ],
    ],
    // This lines opens the configuration for the RouteManager
    'router' => [
      'routes' => [
        'blog' => [
            'type' => 'literal',
            'options' => [
                'route'    => '/blog',
                'defaults' => [
                    'controller' => Controller\ListController::class,
                    'action'     => 'index',
                ],
            ],

            'may_terminate' => true,

            'child_routes'  => [
                'detail' => [
                    'type' => 'segment',
                    'options' => [
                        'route'    => '/:id',
                        'defaults' => [
                            'action' => 'detail',
                        ],
                        'constraints' => [
                            'id' => '[1-9]\d*',
                        ],
                    ],
                ],
            ],
        ],
    ],
],
    'view_manager' => [
      'template_path_stack' => [
          __DIR__ . '/../view',
        ],
    ],
];
