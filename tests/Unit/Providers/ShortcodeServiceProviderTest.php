<?php

namespace Dragon\Tests\Unit\Providers;

use Tests\TestCase;
use Dragon\Providers\ShortcodeServiceProvider;

class ShortcodeServiceProviderTest extends TestCase {
	public function testWillBoot() {
		$provider = new ShortcodeServiceProvider(app());
		$provider->boot();
		
		$this->assertTrue(true);
	}
}
