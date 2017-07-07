<?php

require __DIR__ . '/vendor/autoload.php';

// you can specify a custom lockfile path.
$scheduler = new PHPScheduler\Scheduler();

// non overlapping job, this will create a lockfile and block this job from running again if this one is still running.
// the lockfile contains the PID of the process that is running with the lock.
$scheduler->addJob(
	function() {
		echo "First Job!".PHP_EOL;
		// jobs run independently of each other in seperate PHP processes, this means they can start at *roughly* the same time
		sleep(10);
	}
)->minute()->nonOverlapping('first');

$scheduler->addJob(
	function() {
		echo "Second Job".PHP_EOL;
		sleep(5);
	}
)->minute();

$scheduler->addJob(
	function() {
		echo "Third Job!".PHP_EOL;
		sleep(1);
	}
)->minute();

$scheduler->run();
