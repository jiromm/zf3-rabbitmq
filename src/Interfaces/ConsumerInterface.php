<?php

namespace RabbitMQ\Interfaces;

use RabbitMQ\Service\RabbitMQ;

interface ConsumerInterface
{
    public function receive(Callable $callback, RabbitMQ $rabbitMQService);
}
