<?php

namespace Dragon\Database;

use Illuminate\Support\Facades\Artisan;

class Migrate {
	public static function up() {
		Artisan::call('migrate', ['--force' => true]);
	}
	
	public static function removeDatabaseTables() {
		Artisan::call('migrate:reset', ['--force' => true]);
	}
}
