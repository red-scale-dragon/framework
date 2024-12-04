<?php

namespace Dragon\Http\Form;

class Textbox extends Field {
	private string $type = "text";
	
	public function type(string $type) : static {
		$this->type = $type;
		if ($this->type === "hidden") {
			$this->label("");
		}
		
		return $this;
	}
	
	public function getType() : string {
		return $this->type;
	}
	
	protected function toHtml() : string {
		$out = '<input type="' . $this->getType() . '" name="' . $this->getName() . '" value="' . $this->getValue() . '" ';
		foreach ($this->attributes as $key => $val) {
			$out .= $key . '="' . $val . '" ';
		}
		
		$out .= '/>';
		
		return $out;
	}
}
