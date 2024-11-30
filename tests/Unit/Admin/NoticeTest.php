<?php

namespace Dragon\Tests\Unit\Admin;

use Tests\TestCase;
use Dragon\Admin\Notice;

class NoticeTest extends TestCase {
	public function testCanMakeErrorNotice() {
		$output = outputs(function () {
			Notice::error('Test error');
		});
		
		$this->assertSame('<div class="notice notice-error"><p>Test error</p></div>', $output);
	}
	
	public function testCanMakeSuccessNotice() {
		$output = outputs(function () {
			Notice::success('Test success');
		});
			
		$this->assertSame('<div class="notice notice-success"><p>Test success</p></div>', $output);
	}
	
	public function testCanMakeNotice() {
		$output = outputs(function () {
			Notice::makeNotice('warning', 'Test warning');
		});
			
		$this->assertSame('<div class="notice notice-warning"><p>Test warning</p></div>', $output);
	}
}
