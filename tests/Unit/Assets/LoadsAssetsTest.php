<?php

namespace Dragon\Tests\Unit\Assets;

use Tests\TestCase;
use Dragon\Assets\LoadsAssets;

class StubLoadsAssets {
	use LoadsAssets;
	
	protected static array $scripts = [
		'example-js' => [
			'script' => 'https://example.com/test.js',
		],
	];
	
	protected static array $styles = [
		'example-css' => [
			'style' => 'https://example.com/test.css',
		],
	];
}

class LoadsAssetsTest extends TestCase {
	public function testCanLoadAssets() {
		StubLoadsAssets::loadPageAssets();
		$scripts = wp_scripts();
		$styles = wp_styles();
		
		$this->assertContains('dragonfw_dragonapp_example-js', array_keys($scripts->registered));
		$this->assertContains('dragonfw_dragonapp_example-css', array_keys($styles->registered));
	}
}
