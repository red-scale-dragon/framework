<?php

namespace Dragon\Tests\Unit\Providers;

use Tests\TestCase;
use Dragon\Providers\PostTypeServiceProvider;

class PostTypeServiceProviderTest extends TestCase {
	public function testWillBoot() {
		$provider = new PostTypeServiceProvider(app());
		$provider->boot();
		
		$this->assertTrue(true);
	}
}
