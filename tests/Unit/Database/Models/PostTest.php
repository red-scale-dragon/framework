<?php

namespace Dragon\Tests\Unit\Database\Models;

use Tests\TestCase;
use Dragon\Database\Models\Post;

class PostStub extends Post {
	protected $connection = "wordpress";
};

class PostTest extends TestCase {
	public function testWillNotThrowAnExceptionWhenAccessingTable() {
		PostStub::all();
		$this->assertTrue(true);
	}
}
