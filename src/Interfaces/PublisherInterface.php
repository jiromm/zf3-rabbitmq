<?php

namespace RabbitMQ\Interfaces;

use RabbitMQ\Service\RabbitMQ;

interface PublisherInterface
{
    public function push(JobInterface $job, RabbitMQ $rabbitMQService);
}
