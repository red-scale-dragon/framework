<?php

namespace Dragon\Tests\Unit\Database\Models;

use Tests\TestCase;
use Dragon\Database\Models\UserMeta;

class UserMetaStub extends UserMeta {
	protected $connection = "wordpress";
};

class UserMetaTest extends TestCase {
	public function testWillNotThrowAnExceptionWhenAccessingTable() {
		UserMetaStub::all();
		$this->assertTrue(true);
	}
}
