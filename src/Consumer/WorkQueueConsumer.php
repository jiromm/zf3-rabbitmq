<?php

namespace RabbitMQ\Consumer;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQ\Interfaces\ConsumerInterface;
use RabbitMQ\Service\RabbitMQ;

class WorkQueueConsumer implements ConsumerInterface
{
    protected $queueName;

    public function __construct($queueName)
    {
        $this->queueName = $queueName;
    }

    public function receive(Callable $callback, RabbitMQ $rabbitMQService)
    {
        $channel = $rabbitMQService->getChannel();

        $channel->queue_declare($this->queueName, false, true, false, false);
        $channel->basic_qos(null, 1, null);

        $channel->basic_consume($this->queueName, '', false, false, false, false, function (AMQPMessage $msg) use ($callback) {
            $message = new Message($msg);

            $callback($message);
        });

        while (count($channel->callbacks)) {
            $channel->wait();
        }
    }
}
