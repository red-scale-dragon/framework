<?php

namespace Dragon\Tests\Unit\Database;

use Tests\TestCase;
use Dragon\Database\Migrate;
use Illuminate\Support\Facades\Schema;

class MigrateTest extends TestCase {
	public function testCanRunMigrations() {
		Migrate::up();
		$hasMigrationsTable = Schema::hasTable('dragonfw_migrations');
		
		$this->assertTrue($hasMigrationsTable);
	}
	
	public function testCanResetMigrations() {
		Migrate::up();
		$tables = Schema::getTables();
		
		Migrate::removeDatabaseTables();
		$tablesAfter = Schema::getTables();
		
		$this->assertCount(2, $tables);
		$this->assertCount(1, $tablesAfter);
	}
}
