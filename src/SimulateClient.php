<?php

namespace ParallelTest;

use MongoDB\Client;

class SimulateClient
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * SimulateClient constructor.
     */
    public function __construct()
    {
        $uri = 'mongodb://127.0.0.1:27017/test';
        $this->client = new Client($uri);
        $this->client->listDatabases();
    }
}
