<?php

namespace Dragon\Tests\Unit\Database\Models;

use Tests\TestCase;
use Dragon\Database\Models\Comment;

class CommentStub extends Comment {
	protected $connection = "wordpress";
};

class CommentTest extends TestCase {
	public function testWillNotThrowAnExceptionWhenAccessingTable() {
		CommentStub::all();
		$this->assertTrue(true);
	}
}
