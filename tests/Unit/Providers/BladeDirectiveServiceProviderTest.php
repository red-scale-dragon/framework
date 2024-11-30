<?php

namespace Dragon\Tests\Unit\Providers;

use Tests\TestCase;
use Dragon\Providers\BladeDirectiveServiceProvider;

class BladeDirectiveServiceProviderTest extends TestCase {
	public function testWillBoot() {
		$provider = new BladeDirectiveServiceProvider(app());
		$provider->boot();
		
		$this->assertTrue(true);
	}
}
