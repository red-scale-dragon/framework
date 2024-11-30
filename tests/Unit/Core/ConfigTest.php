<?php

namespace Dragon\Tests\Unit\Core;

use Tests\TestCase;
use Dragon\Core\Config;

class ConfigTest extends TestCase {
	public function testCanSetPluginLoaderAndDirectory() {
		$filePath = __DIR__ . '/../../../../../../loader.php';
		$realpath = realpath($filePath);
		
		Config::setPluginLoaderFile($filePath);
		$file = Config::getLoaderFilename();
		$dir = Config::getBaseDir();
		
		$this->assertSame($realpath, $file);
		$this->assertSame(dirname($realpath), $dir);
	}
	
	public function testCanGetPluginDirectoryName() {
		$path = Config::getBaseDir();
		$name = Config::getPluginDirName();
		
		$parts = explode('/', $path);
		$expected = array_pop($parts);
		$this->assertSame($expected, $name);
	}
	
	public function testCanGetPrefix() {
		$prefix = Config::prefix();
		
		$this->assertSame('dragonfw_dragonapp', $prefix);
	}
	
	public function testCanGetDragonResourcesDir() {
		$dir = Config::dragonResourcesDir();
		
		$expected = realpath(__DIR__ . '/../../../resources');
		$this->assertSame($expected, $dir);
	}
	
	public function testCanGetDragonResourcesDirForHtml() {
		$dir = Config::dragonResourcesDir('', true);
		
		$fullPath = realpath(__DIR__ . '/../../../resources');
		$expected = '/wp-content' . explode('wp-content', $fullPath)[1];
		$this->assertSame($expected, $dir);
	}
	
	public function testCanGetConfigFileData() {
		$appConfig = Config::file('app');
		
		$this->assertIsArray($appConfig);
		$this->assertArrayHasKey('name', $appConfig);
	}
	
	public function testCanGetItemFromConfigArray() {
		$name = Config::get('app.name');
		
		$this->assertSame('Dragon App', $name);
	}
}
