<?php

namespace RabbitMQ\Job;

use RabbitMQ\Exception\InvalidArgumentException;
use RabbitMQ\Interfaces\JobInterface;

class Job implements JobInterface
{
    protected $dataArray = [];
    protected $dataJsonString = '';

    /**
     * @param array|string $data
     * @throws InvalidArgumentException
     */
    public function __construct($data)
    {
        if (is_array($data)) {
            $this->dataJsonString = json_encode($data);
            $this->dataArray = $data;
        } else {
            if (!is_string($data) || !$this->isJson($data)) {
                throw new InvalidArgumentException('Argument should be array or string.');
            }

            $this->dataJsonString = $data;
            $this->dataArray = json_decode(
                stripslashes($data), true
            );
        }
    }

    /**
     * @return array
     */
    public function getJson()
    {
        return $this->dataArray;
    }

    /**
     * @return string
     */
    public function getJsonString()
    {
        return $this->dataJsonString;
    }
}
