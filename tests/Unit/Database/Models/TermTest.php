<?php

namespace Dragon\Tests\Unit\Database\Models;

use Tests\TestCase;
use Dragon\Database\Models\Term;

class TermStub extends Term {
	protected $connection = "wordpress";
};

class TermTest extends TestCase {
	public function testWillNotThrowAnExceptionWhenAccessingTable() {
		TermStub::all();
		$this->assertTrue(true);
	}
}
