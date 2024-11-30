<?php

namespace Dragon\Tests\Unit\Database\Models;

use Tests\TestCase;
use Dragon\Database\Models\PostMeta;

class PostMetaStub extends PostMeta {
	protected $connection = "wordpress";
};

class PostMetaTest extends TestCase {
	public function testWillNotThrowAnExceptionWhenAccessingTable() {
		PostMetaStub::all();
		$this->assertTrue(true);
	}
}
