<?php

namespace Dragon\Tests\Unit\Support;

use Tests\TestCase;
use Dragon\Support\Plugin;

class PluginTest extends TestCase {
	public function testCanGetPathForMediaImageById() {
		$data = Plugin::getData();
		$this->assertNotEmpty($data);
	}
}
