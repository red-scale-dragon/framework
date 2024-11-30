<?php

namespace Dragon\Tests\Unit\Assets;

use Tests\TestCase;
use Dragon\Assets\Asset;

class AssetTest extends TestCase {
	public function testCanGetAppAssetDirectory() {
		$dir = Asset::dir();
		$this->assertSame('/wp-content/plugins/dragonapp/resources/assets', $dir);
	}
	
	public function testCanGetAppAssetDirectoryForAppJs() {
		$dir = Asset::dir('js/global/app.js');
		$this->assertSame('/wp-content/plugins/dragonapp/resources/assets/js/global/app.js', $dir);
	}
	
	public function testCanGetFrameworkAssetDirectoryForAdminTablesJs() {
		$dir = Asset::dir('js/admin/tables.js');
		$this->assertSame(
			'/wp-content/plugins/dragonapp/vendor/red-scale-dragon/framework/resources/assets/js/admin/tables.js', $dir);
	}
	
	public function testCanGetFrameworkAssetDirectoryForImage() {
		$dir = Asset::dir('img/dragon.png');
		$this->assertSame(
			'/wp-content/plugins/dragonapp/vendor/red-scale-dragon/framework/resources/assets/img/dragon.png', $dir);
	}
	
	public function testCanGetFrameworkAssetDirectoryForAdminCss() {
		$dir = Asset::dir('css/global/admin.css');
		$this->assertSame(
			'/wp-content/plugins/dragonapp/vendor/red-scale-dragon/framework/resources/assets/css/global/admin.css', $dir);
	}
	
	public function testWillReturnNullWhenFileMissing() {
		$dir = Asset::dir('js/fake.js');
		$this->assertNull($dir);
	}
	
	public function testCanEnableFrontendAjax() {
		Asset::enableFrontendAjax('jquery-core', false);
		$scripts = wp_scripts();
		$beforeJquery = [];
		if (!empty($scripts->registered['jquery-core']->extra['before'])) {
			$beforeJquery = $scripts->registered['jquery-core']->extra['before'];
		}
		
		$this->assertContains('let ajax_url = "http://example.org/wp-admin/admin-ajax.php";', $beforeJquery);
	}
	
	public function testCanLoadJavascript() {
		Asset::loadScript('test-js', 'https://example.com/test.js');
		$scripts = wp_scripts();
		
		$this->assertContains('dragonfw_dragonapp_test-js', array_keys($scripts->registered));
	}
	
	public function testCanLoadCss() {
		Asset::loadCss('test-css', 'https://example.com/test.css');
		$styles = wp_styles();
		
		$this->assertContains('dragonfw_dragonapp_test-css', array_keys($styles->registered));
	}
	
	public function testCanNamespaceDependencyArray() {
		$namespaced = Asset::namespacedDeps([
			'jquery',
			'test-js',
			'test-css',
		]);
		
		$this->assertSame([
			'jquery',
			'dragonfw_dragonapp_test-js',
			'dragonfw_dragonapp_test-css',
		], $namespaced);
	}
}
