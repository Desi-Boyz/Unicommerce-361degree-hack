<?php
return array(
    'controllers' => array(
        'factories' => array(
            'Start\\V1\\Rpc\\Start\\Controller' => 'Start\\V1\\Rpc\\Start\\StartControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'start.rpc.start' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/start',
                    'defaults' => array(
                        'controller' => 'Start\\V1\\Rpc\\Start\\Controller',
                        'action' => 'start',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'start.rpc.start',
        ),
    ),
    'zf-rpc' => array(
        'Start\\V1\\Rpc\\Start\\Controller' => array(
            'service_name' => 'start',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'start.rpc.start',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Start\\V1\\Rpc\\Start\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'Start\\V1\\Rpc\\Start\\Controller' => array(
                0 => 'application/vnd.start.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
        ),
        'content_type_whitelist' => array(
            'Start\\V1\\Rpc\\Start\\Controller' => array(
                0 => 'application/vnd.start.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
);
