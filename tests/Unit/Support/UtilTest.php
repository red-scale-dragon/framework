<?php

namespace Dragon\Tests\Unit\Support;

use Tests\TestCase;
use Dragon\Support\Util;
use libphonenumber\NumberParseException;

class UtilTest extends TestCase {
	public function testCanNamespaceAString() {
		$this->assertSame('dragonfw_dragonapp_test', Util::namespaced('test'));
	}
	
	public function testCanRemoveNamespacing() {
		$namespaced = Util::namespaced('test');
		$this->assertSame('test', Util::unnamespaced($namespaced));
	}
	
	public function testCanGetDigitsFromMixedCharString() {
		$this->assertSame('123456', Util::onlyDigits('ku1hu2asf3oih4efo;5ubk,6.bug'));
	}
	
	public function testCanCheckIfStringIsAnEmail() {
		$this->assertFalse(Util::isEmail('123456'));
		$this->assertFalse(Util::isEmail('test@'));
		$this->assertFalse(Util::isEmail('@example.com'));
		$this->assertFalse(Util::isEmail('test@localhost')); // WP Filtered
		
		$this->assertTrue(Util::isEmail('test@example.com'));
	}
	
	public function testCanFormatAPhoneNumber() {
		$this->assertSame('+11234', Util::phoneFormat('1234'));
		$this->assertSame('+11231231234', Util::phoneFormat('1231231234'));
		$this->assertSame('+1987654321', Util::phoneFormat('987654321'));
		
		try {
			Util::phoneFormat('987654321123456789');
			$this->assertTrue(false);
		} catch (NumberParseException $e) {
			// Too long
		}
	}
	
	public function testCanGetNthText() {
		$this->assertSame('1st', Util::nth(1));
		$this->assertSame('2nd', Util::nth(2));
		$this->assertSame('3rd', Util::nth(3));
		$this->assertSame('4th', Util::nth(4));
		$this->assertSame('5th', Util::nth(5));
		
		/** 
		 * @link https://github.com/php/php-src/issues/17006
		 */
		$this->assertSame('651,959,195,189rd', Util::nth(651959195189));
	}
	
	public function testCanFormatMoney() {
		$this->assertSame('$1.00', Util::moneyFormat(1));
		$this->assertSame('RUB 1.00', Util::moneyFormat(1, 'RUB'));
		$this->assertSame('DOG 1.00', Util::moneyFormat(1, 'DOGE'));
		$this->assertSame('SMA 1.00', Util::moneyFormat(1, 'SMACKS'));
		$this->assertSame('CA$1.00', Util::moneyFormat(1, 'CAD'));
		$this->assertSame('€1.00', Util::moneyFormat(1, 'EUR'));
	}
}
