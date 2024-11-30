<?php

namespace Dragon\Http\Form;

class Textbox extends Field {
	private string $type = "text";
	
	public function type(string $type) : static {
		$this->type = $type;
		return $this;
	}
	
	public function getType() : string {
		return $this->type;
	}
	
	public function render(): string {
		$out = '<input type="' . $this->getType() . '" name="' . $this->getName() . '" value="' . $this->getValue() . '" ';
		foreach ($this->attributes as $key => $val) {
			$out .= $key . '="' . $val . '" ';
		}
		
		$out .= '/>';
		
		return $out;
	}
}