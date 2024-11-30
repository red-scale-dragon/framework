<?php

namespace Dragon\Tests\Unit\Hooks;

use Tests\TestCase;
use Illuminate\Support\Facades\Config;
use Dragon\Exceptions\Handler;
use Dragon\Hooks\AdminPluginHooks;
use Dragon\Database\Option;

class AdminPluginHooksTest extends TestCase {
	public function testWillEnqueueActions() {
		$hooks = new AdminPluginHooks();
		$this->assertEmpty($hooks->getActions());
		
		$hooks->init();
		$this->assertNotEmpty($hooks->getActions());
	}
	
	public function testWillEnqueueFilters() {
		$hooks = new AdminPluginHooks();
		$this->assertEmpty($hooks->getFilters());
		
		$hooks->init();
		$this->assertNotEmpty($hooks->getFilters());
	}
	
	public function testWillEnableOnActivationOption() {
		$justActivated = Option::get('just_activated', 'no');
		$this->assertSame('no', $justActivated);
		
		AdminPluginHooks::onActivation();
		
		$justActivated = Option::get('just_activated', 'no');
		$this->assertSame('yes', $justActivated);
	}
	
	public function testCanRunDeactivationHook() {
		AdminPluginHooks::onDeactivation();
		$this->assertTrue(true);
	}
	
	public function testCanBuildMenu() {
		AdminPluginHooks::buildAdminMenu();
		$this->assertTrue(true);
	}
}
