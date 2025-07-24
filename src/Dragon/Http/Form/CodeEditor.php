<?php

namespace Dragon\Http\Form;

class CodeEditor extends Field {
	protected function toHtml() : string {
		$this->attributes['language'] ??= 'PHP';
		$editor = '<code-input template="syntax-highlighted" name="' . $this->getName() . '" ';
		foreach ($this->attributes as $key => $val) {
			$editor .= $key . '="' . $val . '" ';
		}
		
		$editor .= '>' . $this->getValue() . '</code-input>';
		
		return $editor;
	}
}
