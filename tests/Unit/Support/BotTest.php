<?php

namespace Dragon\Tests\Unit\Support;

use Tests\TestCase;
use Dragon\Support\Bot;

class BotTest extends TestCase {
	public function testWillDiscoverBot() {
		$this->assertTrue(Bot::isBot('Googlebot'));
	}
	
	public function testWillAllowValidUserAgent() {
		$this->assertFalse(Bot::isBot('test'));
	}
}
