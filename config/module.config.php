<?php

use Interop\Container\ContainerInterface;
use RabbitMQ\Service\RabbitMQ;

return [
    'service_manager' => [
        'factories' => [
            \RabbitMQ\Service\RabbitMQ::class => function (ContainerInterface $container) {
                $config = $container->get('config');

                return new RabbitMQ($config['rabbitmq']);
            },
        ],
    ],
];
