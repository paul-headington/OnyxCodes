<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'OnyxCode\Controller\Code' => 'OnyxCode\Controller\CodeController',
        ),
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
