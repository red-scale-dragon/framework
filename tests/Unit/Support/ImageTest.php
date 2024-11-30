<?php

namespace Dragon\Tests\Unit\Support;

use Tests\TestCase;
use Dragon\Support\Image;

class ImageTest extends TestCase {
	public function testCanGetMediaImageUrlById() {
		$file = realpath(__DIR__ . '/../../fixtures/dragon.png');
		$id = $this->factory->attachment->create_upload_object($file);
		$url = Image::getMediaImageUrlById($id);
		
		$this->assertStringStartsWith('http://example.org/wp-content/uploads/', $url);
	}
	
	public function testCanGetPathForMediaImageById() {
		$file = realpath(__DIR__ . '/../../fixtures/dragon.png');
		$id = $this->factory->attachment->create_upload_object($file);
		$path = Image::getPathForMediaImageById($id);
		
		$this->assertStringStartsWith('/', $path);
	}
}
