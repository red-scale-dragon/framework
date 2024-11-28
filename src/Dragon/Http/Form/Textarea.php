<?php

namespace Dragon\Http\Form;

class Textarea extends Field {
	public function render(): string {
		$out = '<textarea name="' . $this->getName() . '" ';
		foreach ($this->attributes as $key => $val) {
			$out .= $key . '="' . $val . '" ';
		}
		
		$out .= '>' . $this->getValue() . '</textarea>';
		
		return $out;
	}
}
