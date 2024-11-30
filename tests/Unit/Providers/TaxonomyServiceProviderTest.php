<?php

namespace Dragon\Tests\Unit\Providers;

use Tests\TestCase;
use Dragon\Providers\TaxonomyServiceProvider;

class TaxonomyServiceProviderTest extends TestCase {
	public function testWillBoot() {
		$provider = new TaxonomyServiceProvider(app());
		$provider->boot();
		
		$this->assertTrue(true);
	}
}
