<?php

namespace ParallelTest;

use Exception;
use parallel\Future;
use parallel\Runtime;
use Throwable;

class SimulateThread
{
    /**
     * @param string $message
     *
     * @return Future
     */
    public static function run(string $message): Future
    {
        $bootstrap = realpath(__DIR__ . '/../vendor/autoload.php');
        $runtime = new Runtime($bootstrap);
        return $runtime->run(
            function ($message) {
                try {
                    $seconds = rand(11, 15);
                    echo "$message thread started\r\n";
                    $client = new SimulateClient();
                    sleep($seconds);
                    echo "$message thread completed\r\n";
                } catch (Exception $exception) {
                    echo "{$exception->getMessage()}\r\n";
                }

                return strrev($message);
            },
            [$message]
        );
    }

    /**
     * @param Future[] $futures
     *
     * @return string[]
     * @throws Throwable
     */
    public static function wait(array $futures): array
    {
        $results = [];

        foreach ($futures as $future) {
            $results[] = $future->value();
        }

        return $results;
    }
}
