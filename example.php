<?php

require __DIR__ . '/vendor/autoload.php';

$scheduler = new PHPScheduler\Scheduler();

$scheduler->addJob(function() { echo "hello!"; })->everyFiveMinutes();
$scheduler->addJob(function() { echo "hello again!"; })->minute();

$scheduler->run();
