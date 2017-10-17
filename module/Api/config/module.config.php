<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Api;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'load-winners' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/api',
                    'defaults' => [
                        'controller' => Controller\ApiController::class,
                        'action' => 'index',
                    ],
                ],
            ],




        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ApiController::class => InvokableFactory::class,
        ],
    ],

    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],

        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'api/index/index' => __DIR__ . '/../view/Api/api/index.phtml'

        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],

    ],
    'doctrine' => [
        'driver' => [

             __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/doctrine',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entidade' => __NAMESPACE__ . '_driver',
                ],
            ],

            /*__NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/doctrine',
                ],
            ],

            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . 'Application\Entidade' => __NAMESPACE__ . '_driver',
                ],
            ],*/

        ],
    ],


];


