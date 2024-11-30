<?php

namespace Dragon\Tests\Unit\Exceptions;

use Tests\TestCase;
use Illuminate\Support\Facades\Config;
use Dragon\Exceptions\Handler;

class ExceptionStub extends \Exception {}

class HandlerTest extends TestCase {
	public function testCanIgnoreMessages() {
		$messages = Config::get('errors.ignore_messages', ["test"]);
		
		$exception = new ExceptionStub($messages[0]);
		$shouldShow = Handler::shouldShow(true, $exception);
		
		$this->assertFalse($shouldShow);
	}
	
	public function testWillShowNonIgnoredMessage() {
		$exception = new ExceptionStub(random_int(9999, 50000000));
		$shouldShow = Handler::shouldShow(true, $exception);
		
		$this->assertTrue($shouldShow);
	}
}
