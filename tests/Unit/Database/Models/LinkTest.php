<?php

namespace Dragon\Tests\Unit\Database\Models;

use Tests\TestCase;
use Dragon\Database\Models\Link;

class LinkStub extends Link {
	protected $connection = "wordpress";
};

class LinkTest extends TestCase {
	public function testWillNotThrowAnExceptionWhenAccessingTable() {
		LinkStub::all();
		$this->assertTrue(true);
	}
}
