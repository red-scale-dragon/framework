<?php

namespace Dragon\Tests\Unit\Providers;

use Tests\TestCase;
use Dragon\Providers\AssetsServiceProvider;

class AssetsServiceProviderTest extends TestCase {
	public function testWillBoot() {
		$provider = new AssetsServiceProvider(app());
		$provider->boot();
		
		$this->assertTrue(true);
	}
}
