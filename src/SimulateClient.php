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
     *
     * @param bool $persistence
     */
    public function __construct(bool $persistence)
    {
        $uri = 'mongodb://127.0.0.1:27017/test';
        $this->client = new Client($uri, [], ['disableClientPersistence' => !$persistence]);
        $this->client->listDatabases();
    }
}
