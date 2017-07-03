<?php

namespace PHPScheduler;

class Job {

	private $cron_handler;
	private $callable;
	
	public function __construct($cron_expression, Callable $func) {
		$this->cron_handler = \Cron\CronExpression::factory($cron_expression);
		$this->callable = $func;
	}

	public function isDue() {
		if ($this->cron_handler->isDue()) {
			return true;
		} else {
			echo 'Job is Due to be run at: ' . $this->cron_handler->getNextRunDate()->format('Y-m-d H:i:s').PHP_EOL;
		}
	}

	public function run() {
		call_user_func($this->callable);
	}

}