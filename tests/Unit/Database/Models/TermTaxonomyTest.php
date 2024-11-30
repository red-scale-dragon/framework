<?php

namespace Dragon\Tests\Unit\Database\Models;

use Tests\TestCase;
use Dragon\Database\Models\TermTaxonomy;

class TermTaxonomyStub extends TermTaxonomy {
	protected $connection = "wordpress";
};

class TermTaxonomyTest extends TestCase {
	public function testWillNotThrowAnExceptionWhenAccessingTable() {
		TermTaxonomyStub::all();
		$this->assertTrue(true);
	}
}
