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

