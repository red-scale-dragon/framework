<?php

namespace Dragon\Tests\Unit\Http\Form;

use Tests\TestCase;
use Dragon\Http\Form\Textarea;

class TextareaTest extends TestCase {
	public function testWillRenderTextarea() {
		$actual = Textarea::make('test_textarea')->render();
		$expected = '<textarea name="test_textarea" ></textarea>';
		$this->assertSame($expected, $actual);
	}
	
	public function testWillSetIdAttribute() {
		$actual = Textarea::make('test_textarea')
		->attributes(['id' => 'test'])
		->render();
		
		$expected = '<textarea name="test_textarea" id="test" ></textarea>';
		$this->assertSame($expected, $actual);
	}
	
	public function testWillSetValue() {
		$actual = Textarea::make('test_textarea')
		->value('test')
		->render();
		
		$expected = '<textarea name="test_textarea" >test</textarea>';
		$this->assertSame($expected, $actual);
	}
}
