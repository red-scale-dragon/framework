<?php

namespace Dragon\Tests\Unit\Database\Models;

use Tests\TestCase;
use Dragon\Database\Models\User;

class UserStub extends User {
	protected $connection = "wordpress";
};

class UserTest extends TestCase {
	public function testWillNotThrowAnExceptionWhenAccessingTable() {
		UserStub::all();
		$this->assertTrue(true);
	}
}
