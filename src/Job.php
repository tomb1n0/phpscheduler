<?php

namespace PHPScheduler;

class Job {

	private $cron_handler;
	private $callable;
	private $lockfile;
	private $scheduler;

	public function __construct(\PHPScheduler\Scheduler $scheduler, $cron_expression, Callable $func) {
		$this->scheduler = $scheduler;
		$this->cron_handler = \Cron\CronExpression::factory($cron_expression);
		$this->callable = $func;
	}

	public function nonOverlapping($lock_name) {
		$this->lockfile = $lock_name . '.lock';
		return $this;
	}

	public function lock() {
		if (file_exists($this->scheduler->lockpath() . $this->lockfile)) {
			$pid = file_get_contents($this->scheduler->lockpath() . $this->lockfile);
			throw new \Exception('A previous job with pid ' . $pid . ' has locked ' . $this->lockfile . ', perhaps it is still running?');
		}
		file_put_contents($this->scheduler->lockpath() . $this->lockfile, getmypid());
	}

	public function unlock() {
		return unlink($this->scheduler->lockpath() . $this->lockfile);
	}

	public function isDue() {
		return $this->cron_handler->isDue();
	}

	public function run() {
		try {
			if (isset($this->lockfile)) {
				$this->lock();
			}
			call_user_func($this->callable);
			if (isset($this->lockfile)) {
				$this->unlock();
			}
		} catch (\Exception $e) {
			var_dump($e->getMessage());
		}
	}

}