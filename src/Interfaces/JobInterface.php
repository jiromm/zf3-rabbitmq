<?php

namespace RabbitMQ\Interfaces;

interface JobInterface
{
    public function getJsonString();
    public function getJson();
}
