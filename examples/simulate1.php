<?php

use ParallelTest\SimulateThread;

require_once __DIR__ . '/../vendor/autoload.php';

$pid = getmypid();

echo "Process ID: {$pid}\r\n";

$fruits = ['Apple', 'Banana', 'Cherry', 'Orange'];
$futures = [];

while (true) {
    $date = date('H:i:s');
    echo "--- {$date} ---\r\n";
    foreach ($fruits as $key => $fruit) {
        $futures[] = SimulateThread::run($fruit);
        unset($fruits[$key]);
    }

    echo "Sleep for 10 seconds ...\r\n";
    sleep(10);

    echo "Waiting for thread results ...\r\n";
    foreach ($futures as $key => $future) {
        $result = $future->value();
        unset($futures[$key]);
        $fruits[] = $result;
    }

    echo "All threads completed!\r\n\r\n";
    sleep(1);

    passthru("lsof -p {$pid} | grep 27017");
    echo "\r\n";

    passthru("ps huH -p {$pid}");
    echo "\r\n";

    echo "Next loop in 5 seconds ...\r\n\r\n\r\n";
    sleep(5);
}
