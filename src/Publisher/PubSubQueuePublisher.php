<?php

namespace RabbitMQ\Publisher;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQ\Interfaces\JobInterface;
use RabbitMQ\Service\RabbitMQ;

class PubSubQueuePublisher extends WorkQueuePublisher
{
    public function push(JobInterface $job, RabbitMQ $rabbitMQService)
    {
        $channel = $rabbitMQService->getChannel();

        $channel->exchange_declare($this->queueName, 'fanout', false, false, false);
        $msg = new AMQPMessage($job->getJsonString());

        $channel->basic_publish($msg, $this->queueName);
    }
}
