<?php

namespace Dragon\Tests\Unit\Database\Models;

use Tests\TestCase;
use Dragon\Database\Models\TermMeta;

class TermMetaStub extends TermMeta {
	protected $connection = "wordpress";
};

class TermMetaTest extends TestCase {
	public function testWillNotThrowAnExceptionWhenAccessingTable() {
		TermMetaStub::all();
		$this->assertTrue(true);
	}
}
