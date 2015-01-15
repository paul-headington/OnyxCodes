<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'OnyxCode\Controller\Code' => 'OnyxCode\Controller\CodeController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'system-code' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/system/codes',
                    'defaults' => array(
                        '__NAMESPACE__' => 'OnyxCode\Controller',
                        'controller'    => 'code',
                        'action'        => 'index',
                    ),
                ),
            ),  
            'system-code-create-all' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/system/codes/create-all',
                    'defaults' => array(
                        '__NAMESPACE__' => 'OnyxCode\Controller',
                        'controller'    => 'code',
                        'action'        => 'createall',
                    ),
                ),
            ), 
            'system-code-generate' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/system/codes/generate[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'OnyxCode\Controller',
                        'controller'    => 'code',
                        'action'        => 'generate',
                        'id'            => null
                    ),
                ),
            ),
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'cli-code-create-all' => array(
                    'options' => array(
                                    // add [ and ] if optional ( ex : [<doname>] )
                        'route' => 'codes createall [--verbose|-v]', 
                        'defaults' => array(
                            '__NAMESPACE__' => 'OnyxCode\Controller',
                            'controller'    => 'code',
                            'action'        => 'clicreateall',
                        ),
                    ),
                ),
            )
        )
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'onyxadmin' => __DIR__ . '/../view',
        ),
    ),
    'service_manager'=> array(
        'abstract_factories' => array(
        ),
    ),
);
