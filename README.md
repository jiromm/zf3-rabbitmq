# zf3-rabbitmq
ZF3 Module for RabbitMQ

## Install

`composer require jiromm/zf3-rabbitmq`


## Configure

create configuration with `rabbitmq` key as described below:

```php
<?php

return [
    'rabbitmq' => [
        'host'     => 'localhost',
        'port'     => 5672,
        'login'    => 'guest',
        'password' => 'guest',
    ],
]
```

Make sure the module enabled and try an example below.

### Send message

```php
<?php

/**
 * @var \RabbitMQ\Service\RabbitMQ $rabbitmqService
 * @var \Interop\Container\ContainerInterface $container
 */

$rabbitMQ = $container->get(\RabbitMQ\Service\RabbitMQ::class);
$publisher = new \RabbitMQ\Publisher\WorkQueuePublisher('test_work_queue');
$job = new \RabbitMQ\Job\Job(['some' => 'data');

$rabbitMQ->setPublisher($publisher);
$rabbitMQ->push($job);
```

### Receive message

```php
<?php

/**
 * @var \RabbitMQ\Service\RabbitMQ $rabbitmqService
 * @var \Interop\Container\ContainerInterface $container
 */

$rabbitMQ = $container->get(\RabbitMQ\Service\RabbitMQ::class);
$consumer = new \RabbitMQ\Consumer\WorkQueueConsumer($queueName);
$rabbitMQ->setConsumer($consumer);

$rabbitMQ->receive(function (\RabbitMQ\Consumer\Message $message) {
    echo $message->getBody();

    $message->ack();
});
```
