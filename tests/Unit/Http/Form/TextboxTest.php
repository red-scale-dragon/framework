<?php

namespace Dragon\Tests\Unit\Http\Form;

use Tests\TestCase;
use Dragon\Http\Form\Textbox;

class TextboxTest extends TestCase {
	public function testWillRenderTextbox() {
		$actual = Textbox::make('test_textbox')->render();
		$expected = '<input type="text" name="test_textbox" value="" />';
		$this->assertSame($expected, $actual);
	}
	
	public function testWillSetIdAttribute() {
		$actual = Textbox::make('test_textarea')
		->attributes(['id' => 'test'])
		->render();
		
		$expected = '<input type="text" name="test_textarea" value="" id="test" />';
		$this->assertSame($expected, $actual);
	}
	
	public function testWillSetValue() {
		$actual = Textbox::make('test_textarea')
		->value('test')
		->render();
		
		$expected = '<input type="text" name="test_textarea" value="test" />';
		$this->assertSame($expected, $actual);
	}
	
	public function testWillSetType() {
		$actual = Textbox::make('test_textarea')
		->type('hidden')
		->render();
		
		$expected = '<input type="hidden" name="test_textarea" value="" />';
		$this->assertSame($expected, $actual);
	}
}
