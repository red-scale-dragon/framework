<?php

namespace Dragon\Tests\Unit\Providers;

use Tests\TestCase;
use Dragon\Providers\FormRequestServiceProvider;

class FormRequestServiceProviderTest extends TestCase {
	public function testWillBoot() {
		$provider = new FormRequestServiceProvider(app());
		$provider->boot();
		
		$this->assertTrue(true);
	}
}
