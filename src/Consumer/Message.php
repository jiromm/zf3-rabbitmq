<?php

namespace RabbitMQ\Consumer;

use PhpAmqpLib\Message\AMQPMessage;

class Message
{
    /**
     * @var AMQPMessage
     */
    protected $message;

    public function __construct(AMQPMessage $message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->message->body;
    }

    public function ack()
    {
        $this->message->delivery_info['channel']->basic_ack(
            $this->message->delivery_info['delivery_tag']
        );
    }
}
