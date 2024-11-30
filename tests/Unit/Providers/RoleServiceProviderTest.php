<?php

namespace Dragon\Tests\Unit\Providers;

use Tests\TestCase;
use Dragon\Providers\RoleServiceProvider;

class RoleServiceProviderTest extends TestCase {
	public function testWillBoot() {
		$provider = new RoleServiceProvider(app());
		$provider->boot();
		
		$this->assertTrue(true);
	}
}
