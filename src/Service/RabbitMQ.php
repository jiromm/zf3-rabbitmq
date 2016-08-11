<?php

namespace RabbitMQ\Service;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Wire\AMQPTable;
use RabbitMQ\Interfaces\ConsumerInterface;
use RabbitMQ\Interfaces\JobInterface;
use RabbitMQ\Interfaces\PublisherInterface;

class RabbitMQ
{
    const DELIVERY_MODE = 2;

    const PRIORITY_SUPER_LOW  = 1;
    const PRIORITY_LOW        = 2;
    const PRIORITY_NORMAL     = 3;
    const PRIORITY_HIGH       = 4;
    const PRIORITY_SUPER_HIGH = 5;

    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * @var AMQPChannel
     */
    private $channel;

    /**
     * @var AMQPTable
     */
    private $table;

    /**
     * @var PublisherInterface
     */
    private $publisher;

    /**
     * @var ConsumerInterface
     */
    private $consumer;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->table = new AMQPTable();
        $this->connection = new AMQPStreamConnection(
            $config['host'],
            $config['port'],
            $config['login'],
            $config['password']
        );

        $this->channel = $this->connection->channel();
    }

    /**
     * @param JobInterface $job
     */
    public function push(JobInterface $job)
    {
        if (is_null($this->publisher)) {
            throw new \DomainException('Publisher not defined.');
        }

        $this->publisher->push($job, $this);
    }

    /**
     * @param Callable $callback
     */
    public function receive(Callable $callback)
    {
        $this->consumer->receive($callback, $this);
    }

    /**
     * @param PublisherInterface $publisher
     */
    public function setPublisher(PublisherInterface $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @param ConsumerInterface $consumer
     */
    public function setConsumer(ConsumerInterface $consumer)
    {
        $this->consumer = $consumer;
    }

    /**
     * @return AMQPTable
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return AMQPStreamConnection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
