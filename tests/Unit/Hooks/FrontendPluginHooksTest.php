<?php

namespace Dragon\Tests\Unit\Hooks;

use Tests\TestCase;
use Dragon\Hooks\FrontendPluginHooks;

class FrontendPluginHooksTest extends TestCase {
	public function testWillEnqueueActions() {
		$hooks = new FrontendPluginHooks();
		$this->assertEmpty($hooks->getActions());
		
		$hooks->init();
		$this->assertNotEmpty($hooks->getActions());
	}
	
	public function testWillEnqueueFilters() {
		$hooks = new FrontendPluginHooks();
		$this->assertEmpty($hooks->getFilters());
		
		$hooks->init();
		$this->assertNotEmpty($hooks->getFilters());
	}
}
