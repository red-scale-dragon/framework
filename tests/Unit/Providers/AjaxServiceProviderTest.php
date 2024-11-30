<?php

namespace Dragon\Tests\Unit\Providers;

use Tests\TestCase;
use Dragon\Providers\AjaxServiceProvider;

class AjaxServiceProviderTest extends TestCase {
	public function testWillBoot() {
		$provider = new AjaxServiceProvider(app());
		$provider->boot();
		
		$this->assertTrue(true);
	}
}
