<?php

namespace Dragon\Tests\Unit\Assets;

use Tests\TestCase;

class HelpersTest extends TestCase {
	public function testWillReturnAPathForAnImage() {
		$file = \Dragon\Assets\image('dragon.png');
		$this->assertSame(
			'/wp-content/plugins/dragonapp/vendor/red-scale-dragon/framework/resources/assets/img/dragon.png', $file);
	}
	
	public function testWillReturnAPathForACssFile() {
		$file = \Dragon\Assets\css('global/admin.css');
		$this->assertSame(
			'/wp-content/plugins/dragonapp/vendor/red-scale-dragon/framework/resources/assets/css/global/admin.css', $file);
	}
	
	public function testWillReturnAPathForAJsFile() {
		$file = \Dragon\Assets\js('global/app.js');
		$this->assertSame(
			'/wp-content/plugins/dragonapp/resources/assets/js/global/app.js', $file);
	}
}
