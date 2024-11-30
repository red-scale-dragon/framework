<?php

namespace Dragon\Tests\Unit\Providers;

use Tests\TestCase;
use Dragon\Providers\CronServiceProvider;

class CronServiceProviderTest extends TestCase {
	public function testWillBoot() {
		$provider = new CronServiceProvider(app());
		$provider->boot();
		
		$this->assertTrue(true);
	}
}
