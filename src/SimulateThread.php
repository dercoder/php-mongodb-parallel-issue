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
     * @param bool   $persistence
     *
     * @return Future
     */
    public static function run(string $message, bool $persistence): Future
    {
        $bootstrap = realpath(__DIR__ . '/../vendor/autoload.php');
        $runtime = new Runtime($bootstrap);
        return $runtime->run(
            function ($message, $persistence) {
                try {
                    $seconds = rand(11, 15);
                    echo "$message thread started\r\n";
                    $client = new SimulateClient($persistence);
                    sleep($seconds);
                    echo "$message thread completed\r\n";
                } catch (Exception $exception) {
                    echo "{$exception->getMessage()}\r\n";
                }

                return strrev($message);
            },
            [$message, $persistence]
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
