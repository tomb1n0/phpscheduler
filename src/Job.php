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
		return $this->cron_handler->isDue();
	}

	public function run() {
		call_user_func($this->callable);
	}

}