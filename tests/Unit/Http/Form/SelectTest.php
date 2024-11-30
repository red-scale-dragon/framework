<?php

namespace Dragon\Tests\Unit\Http\Form;

use Tests\TestCase;
use Dragon\Http\Form\Select;

class SelectTest extends TestCase {
	public function testWillRenderOptions() {
		$actual = Select::make('test_select')
		->options([
			'option1' => 'Option 1',
			'option2' => 'Option 2',
		])
		->render();
		
		$expected = '<select name="test_select" ><option value="option1">Option 1</option><option value="option2">Option 2</option></select>';
		$this->assertSame($expected, $actual);
	}
	
	public function testWillSetSelectedOption() {
		$select = Select::make('test_select')
		->options([
			'option1' => 'Option 1',
			'option2' => 'Option 2',
		])
		->value('option2');
		
		$this->assertSame('option2', $select->getValue());
		
		$actual = $select->render();
		$expected = '<select name="test_select" ><option value="option1">Option 1</option><option value="option2" selected>Option 2</option></select>';
		$this->assertSame($expected, $actual);
	}
	
	public function testWillSetIdAttribute() {
		$select = Select::make('test_select')
		->options([
			'option1' => 'Option 1',
			'option2' => 'Option 2',
		])
		->attributes(['id' => 'test']);
		
		$this->assertSame(['id' => 'test'], $select->getAttributes());
		
		$actual = $select->render();
		$expected = '<select name="test_select" id="test"><option value="option1">Option 1</option><option value="option2">Option 2</option></select>';
		$this->assertSame($expected, $actual);
	}
	
	public function testWillSetLabel() {
		$select = Select::make('test_select')->label('My test label');
		$this->assertSame('My test label', $select->getLabel());
	}
	
	public function testWillSetRequiredStatus() {
		$select = Select::make('test_select');
		$this->assertFalse($select->isRequired());
		
		$select = $select->required();
		$this->assertTrue($select->isRequired());
	}
	
	public function testWillSetEncryptedStatus() {
		$select = Select::make('test_select');
		$this->assertFalse($select->isEncrypted());
		
		$select = $select->encrypted();
		$this->assertTrue($select->isEncrypted());
	}
}
