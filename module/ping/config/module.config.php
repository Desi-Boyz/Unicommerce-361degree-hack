<?php
return array(
    'router' => array(
        'routes' => array(
            'ping.rpc.ping' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/ping',
                    'defaults' => array(
                        'controller' => 'ping\\V1\\Rpc\\Ping\\Controller',
                        'action' => 'ping',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            1 => 'ping.rpc.ping',
        ),
    ),
    'service_manager' => array(
        'factories' => array(),
    ),
    'zf-rest' => array(),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'ping\\V1\\Rpc\\Ping\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'ping\\V1\\Rpc\\Ping\\Controller' => array(
                0 => 'application/vnd.ping.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
        ),
        'content_type_whitelist' => array(
            'ping\\V1\\Rpc\\Ping\\Controller' => array(
                0 => 'application/vnd.ping.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(),
    ),
    'controllers' => array(
        'factories' => array(
            'ping\\V1\\Rpc\\Ping\\Controller' => 'ping\\V1\\Rpc\\Ping\\PingControllerFactory',
        ),
    ),
    'zf-rpc' => array(
        'ping\\V1\\Rpc\\Ping\\Controller' => array(
            'service_name' => 'ping',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'ping.rpc.ping',
        ),
    ),
    'zf-content-validation' => array(
        'ping\\V1\\Rpc\\Ping\\Controller' => array(
            'input_filter' => 'ping\\V1\\Rpc\\Ping\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'ping\\V1\\Rpc\\Ping\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'ok',
            ),
        ),
    ),
);
