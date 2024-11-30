<?php

namespace Dragon\Tests\Unit\Http;

use Tests\TestCase;
use function Dragon\Http\nonce;

class HelpersTest extends TestCase {
	public function testCanCreateNonceField() {
		$field = nonce();
		
		$this->assertStringStartsWith('<input name="dragonfw_dragonapp_nonce" value="', $field);
		$this->assertStringEndsWith('" type="hidden" />', $field);
	}
}
