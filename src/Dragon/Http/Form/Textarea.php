<?php

namespace Dragon\Http\Form;

class Textarea extends Field {
	protected function toHtml() : string {
		$out = '<textarea name="' . $this->getName() . '" ';
		foreach ($this->attributes as $key => $val) {
			$out .= $key . '="' . $val . '" ';
		}
		
		$out .= '>' . $this->getValue() . '</textarea>';
		
		return $out;
	}
}
