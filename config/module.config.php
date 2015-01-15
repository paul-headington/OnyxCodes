<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'OnyxPrize\Controller\Prize' => 'OnyxPrize\Controller\PrizeController',
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
