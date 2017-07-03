<?php

require __DIR__ . '/vendor/autoload.php';

$scheduler = new PHPScheduler\Scheduler('jobs');

function jobs(PHPScheduler\Scheduler $scheduler) {
	$scheduler->everyFiveMinutes(function () {
		echo "Every 5 Mins";
	});
	$scheduler->midnight(function () {
		echo "Midnight!";
	});
}

