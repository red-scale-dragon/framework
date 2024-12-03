<?php

namespace Dragon\Http\Form;

class Select extends Field {
	private array $options = [];
	
	public function options(array $options) : static {
		$this->options = $options;
		return $this;
	}
	
	protected function toHtml() : string {
		$out = '<select name="' . $this->getName() . '" ';
		foreach ($this->getAttributes() as $key => $val) {
			$out .= $key . '="' . $val . '"';
		}
		$out .= '>';
		
		foreach ($this->options as $value => $text) {
			$out .= '<option value="' . $value . '"';
			if (old($this->getName(), $this->getValue()) === $value) {
				$out .= ' selected';
			}
			$out .= '>' . $text . '</option>';
		}
		
		$out .= '</select>';
		
		return $out;
	}
}
