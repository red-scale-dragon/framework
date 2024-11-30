<?php

namespace Dragon\Tests\Unit\Database;

use Tests\TestCase;
use Dragon\Database\Option;

class OptionTest extends TestCase {
	public function testCanSetOption() {
		Option::set('test', 'blah');
		$value = Option::get('test', 'not blah');
		
		$this->assertSame('blah', $value);
	}
	
	public function testCanDeleteOption() {
		Option::set('test', 'blah');
		Option::delete('test');
		$value = Option::get('test', 'not blah');
		
		$this->assertSame('not blah', $value);
	}
}
