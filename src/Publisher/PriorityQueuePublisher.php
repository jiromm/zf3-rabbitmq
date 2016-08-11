<?php

namespace RabbitMQ\Publisher;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQ\Interfaces\JobInterface;
use RabbitMQ\Service\RabbitMQ;

class PriorityQueuePublisher extends WorkQueuePublisher
{
    protected $priority;

    public function __construct($queueName, $priority)
    {
        parent::__construct($queueName);

        $this->priority = $priority;
    }

    public function push(JobInterface $job, RabbitMQ $rabbitMQService)
    {
        $table = $rabbitMQService->getTable();
        $channel = $rabbitMQService->getChannel();

        $table->set('x-max-priority', RabbitMQ::PRIORITY_SUPER_HIGH);
        $channel->queue_declare($this->queueName, false, true, false, false, false, $table);

        $amqpMessage = new AMQPMessage($job->getJson(), [
            'delivery_mode' => RabbitMQ::DELIVERY_MODE,
            'priority' => $this->priority,
        ]);

        $channel->basic_publish($amqpMessage, '', $this->queueName);
    }
}
