<?php

namespace PHPScheduler;

class Scheduler {

	private $jobs;
	private $config;

	public function __construct($config = []) {
		$this->config = array_merge(['lockpath' => __DIR__ . '/../lockfiles/'], $config);
		$this->jobs = [];
	}

	public function addJob(Callable $func) {
		$this->temp_func = $func;
		return $this;
	}

	public function nonOverlapping($lock_name) {
		return $this;
	}

	public function lockpath() {
		return $this->config['lockpath'];
	}

	public function cron($cron_string) {
		$job = new Job($this, $cron_string, $this->temp_func);
		$this->jobs[] = $job;
		return $job;
	}

	public function run() {
		foreach ($this->jobs as $job) {
			if ($job->isDue()) {
				// fork to a seperate PHP process.
				$pid = pcntl_fork();
				if ($pid === 0) {
					posix_setsid();
					// make our current process a session leader.
					// this means that each job runs independently in a different process and then
					// we're not waiting on the parent session to execute the next job.
					$job->run();
					exit();
				}
			}
		}
	}

	public function minute() {
		return $this->Cron('* * * * *');
	}

	public function everyFiveMinutes() {
		return $this->Cron('*/5 * * * *');
	}

	public function everyTenMinutes() {
		return $this->Cron('*/10 * * * *');
	}

	public function everyFifteenMinutes() {
		return $this->Cron('*/15 * * * *');
	}

	public function halfHourly() {
		return $this->Cron('*/30 * * * *');
	}

	public function hourly() {
		return $this->Cron('0 * * * *');
	}

	public function twiceDaily() {
		return $this->Cron('*/12 * * * *');
	}

	public function midnight() {
		return $this->Cron('0 0 * * *');
	}

}
