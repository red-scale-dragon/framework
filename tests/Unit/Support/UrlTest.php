<?php

namespace Dragon\Tests\Unit\Support;

use Tests\TestCase;
use Dragon\Support\Url;

class UrlTest extends TestCase {
	public function testCanCheckIfRestRequest() {
		$this->assertFalse(Url::isRestRequest());
		define('REST_REQUEST', true);
		$this->assertTrue(Url::isRestRequest());
	}
	
	public function testCanCheckIfStringIsUrl() {
		$this->assertTrue(Url::isUrl('http://example.com'));
		$this->assertTrue(Url::isUrl('//example.com', '//'));
		$this->assertFalse(Url::isUrl('example.com'));
	}
	
	public function testCanGetUrlBySlug() {
		wp_insert_post(['post_type' => 'page', 'post_name' => 'test-slug']);
		$this->assertStringStartsWith('http://example.org/?page_id=', Url::getBySlug('test-slug'));
		$this->assertStringEndsWith('&test=blah', Url::getBySlug('test-slug', ['test' => 'blah']));
	}
	
	public function testCanGetProductUrlBySlug() {
		wp_insert_post(['post_type' => 'product', 'post_name' => 'test-slug']);
		$this->assertStringStartsWith('http://example.org/?p=', Url::getProductBySlug('test-slug'));
	}
	
	public function testCanGetAdminUrlBySlug() {
		add_menu_page('Test', 'Test', 'manage_options', 'dragonfw_dragonapp_test-slug', function(){});
		
		$this->assertSame(
				'http://example.org/wp-admin/admin.php?page=dragonfw_dragonapp_test-slug',
				Url::getAdminMenuLink('test-slug'));
		
		$this->assertStringEndsWith('&test=blah', Url::getAdminMenuLink('test-slug', ['test' => 'blah']));
	}
	
	public function testCanGetCurrentUrl() {
		$this->assertSame('http://example.org', Url::getCurrentUrl());
		$this->assertSame('http://example.org?test=blah', Url::getCurrentUrl(['test' => 'blah']));
	}
}
