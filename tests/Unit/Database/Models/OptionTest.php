<?php

namespace Dragon\Tests\Unit\Database\Models;

use Tests\TestCase;
use Dragon\Database\Models\Option;

class OptionStub extends Option {
	protected $connection = "wordpress";
};

class OptionTest extends TestCase {
	public function testWillNotThrowAnExceptionWhenAccessingTable() {
		OptionStub::all();
		$this->assertTrue(true);
	}
}
