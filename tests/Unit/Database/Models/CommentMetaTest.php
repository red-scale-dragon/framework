<?php

namespace Dragon\Tests\Unit\Database\Models;

use Tests\TestCase;
use Dragon\Database\Models\CommentMeta;

class CommentMetaStub extends CommentMeta {
	protected $connection = "wordpress";
};

class CommentMetaTest extends TestCase {
	public function testWillNotThrowAnExceptionWhenAccessingTable() {
		CommentMetaStub::all();
		$this->assertTrue(true);
	}
}
