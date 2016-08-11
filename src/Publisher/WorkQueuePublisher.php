<?php

namespace RabbitMQ\Publisher;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQ\Interfaces\JobInterface;
use RabbitMQ\Interfaces\PublisherInterface;
use RabbitMQ\Service\RabbitMQ;

class WorkQueuePublisher implements PublisherInterface
{
    protected $queueName;

    public function __construct($queueName)
    {
        $this->queueName = $queueName;
    }

    public function push(JobInterface $job, RabbitMQ $rabbitMQService)
    {
        $table = $rabbitMQService->getTable();
        $channel = $rabbitMQService->getChannel();

        $channel->queue_declare($this->queueName, false, true, false, false, false, $table);

        $amqpMessage = new AMQPMessage($job->getJsonString(), [
            'delivery_mode' => RabbitMQ::DELIVERY_MODE,
        ]);

        $channel->basic_publish($amqpMessage, '', $this->queueName);
    }
}
