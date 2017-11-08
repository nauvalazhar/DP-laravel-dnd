<?php

namespace App\Facades;
use App\Logs;

class LogsFacade {
	public function create($data) {
		$logs = Logs::create($data);
		return $logs;
	}
}