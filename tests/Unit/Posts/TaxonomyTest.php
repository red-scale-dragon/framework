<?php

namespace Dragon\Tests\Unit\Posts;

use Tests\TestCase;
use Dragon\Posts\Taxonomy;

class TaxonomyStub extends Taxonomy {
	protected static string $tag = "test-tax";
	protected static string $name = "Test Tax";
}

class TaxonomyTest extends TestCase {
	public function testCanCreateCustomTaxonomy() {
		$this->assertFalse(taxonomy_exists('test-tax'));
		TaxonomyStub::init();
		$this->assertTrue(taxonomy_exists('test-tax'));
	}
	
	public function testCanGetUpdatedMessages() {
		$messages = TaxonomyStub::updatedMessages([]);
		$this->assertNotEmpty($messages);
	}
}
