<?php

namespace RabbitMQ;

use Psr\Container\ContainerInterface;
use RabbitMQ\Service\RabbitMQ;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                RabbitMQ::class => function (ContainerInterface $container) {
                    $config = $container->get('config');

                    return new RabbitMQ($config['rabbitmq']);
                },
            ],
        ];
    }
}
