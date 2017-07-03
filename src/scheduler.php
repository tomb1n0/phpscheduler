<?php

namespace PHPScheduler;

class Scheduler {

	private $jobs;

	public function __construct(Callable $function) {
		call_user_func_array($function, [$this]);
		$this->run();
	}

	public function cron($cron_string, Callable $func) {
		$this->jobs[] = new Job($cron_string, $func);
	}

	public function run() {
		foreach ($this->jobs as $job) {
			if ($job->isDue()) {
				$job->run();
			}
		}
	}

	public function minute(Callable $func) {
		$this->Cron('* * * * *', $func);
	}

	public function everyFiveMinutes(Callable $func) {
		$this->Cron('*/5 * * * *', $func);
	}

	public function everyTenMinutes(Callable $func) {
		$this->Cron('*/10 * * * *', $func);
	}

	public function everyFifteenMinutes(Callable $func) {
		$this->Cron('*/15 * * * *', $func);
	}
	
	public function halfHourly(Callable $func) {
		$this->Cron('*/30 * * * *', $func);
	}

	public function hourly(Callable $func) {
		$this->Cron('0 * * * *', $func);
	}
	
	public function twiceDaily(Callable $func) {
		$this->Cron('*/12 * * * *', $func);
	}

	public function midnight(Callable $func) {
		$this->Cron('0 0 * * *', $func);
	}

}