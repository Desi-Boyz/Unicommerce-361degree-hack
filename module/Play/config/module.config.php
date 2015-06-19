<?php
return array(
    'controllers' => array(
        'factories' => array(
            'Play\\V1\\Rpc\\Play\\Controller' => 'Play\\V1\\Rpc\\Play\\PlayControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'play.rpc.play' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/play',
                    'defaults' => array(
                        'controller' => 'Play\\V1\\Rpc\\Play\\Controller',
                        'action' => 'play',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'play.rpc.play',
        ),
    ),
    'zf-rpc' => array(
        'Play\\V1\\Rpc\\Play\\Controller' => array(
            'service_name' => 'play',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'play.rpc.play',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Play\\V1\\Rpc\\Play\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'Play\\V1\\Rpc\\Play\\Controller' => array(
                0 => 'application/vnd.play.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
        ),
        'content_type_whitelist' => array(
            'Play\\V1\\Rpc\\Play\\Controller' => array(
                0 => 'application/vnd.play.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
);
