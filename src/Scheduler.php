<?php

namespace PHPScheduler;

class Scheduler {

	private $jobs;

	public function __construct(Callable $function = null) {
		if ($function != null) {
			call_user_func_array($function, [$this]);
		}
		$this->jobs = [];
	}

	public function addJob(Callable $func) {
		$this->temp_func = $func;
		return $this;
	}

	public function cron($cron_string) {
		$this->jobs[] = new Job($cron_string, $this->temp_func);
	}

	public function run() {
		foreach ($this->jobs as $job) {
			if ($job->isDue()) {
				$job->run();
			}
		}
	}

	public function minute() {
		$this->Cron('* * * * *');
	}

	public function everyFiveMinutes() {
		$this->Cron('*/5 * * * *');
	}

	public function everyTenMinutes() {
		$this->Cron('*/10 * * * *');
	}

	public function everyFifteenMinutes() {
		$this->Cron('*/15 * * * *');
	}

	public function halfHourly() {
		$this->Cron('*/30 * * * *');
	}

	public function hourly() {
		$this->Cron('0 * * * *');
	}

	public function twiceDaily() {
		$this->Cron('*/12 * * * *');
	}

	public function midnight() {
		$this->Cron('0 0 * * *');
	}

}
