<?php

namespace Dragon\Http\Form;

use Dragon\Assets\Asset;
use Dragon\Support\Url;

class Textarea extends Field {
	protected bool $isWysiwyg = false;
	protected string $wysiwygClass = "wysiwyg";
	
	public function wysiwyg(bool $enabled = true) {
		$this->isWysiwyg = $enabled;
		return $this;
	}
	
	public function isWysiwyg() {
		return $this->isWysiwyg;
	}
	
	protected function toHtml() : string {
		if ($this->isWysiwyg) {
			$this->loadWysiwygJs();
			if (empty($this->attributes['class'])) {
				$this->attributes['class'] = $this->wysiwygClass;
			} else {
				$this->attributes['class'] .= ' ' . $this->wysiwygClass;
			}
		}
		
		$out = '<textarea name="' . $this->getName() . '" ';
		foreach ($this->attributes as $key => $val) {
			$out .= $key . '="' . $val . '" ';
		}
		
		$out .= '>' . $this->getValue() . '</textarea>';
		
		return $out;
	}
	
	protected function loadWysiwygJs() {
		Asset::loadScript(
				'dragon-tinymce',
				Url::pluginUrl('vendor/tinymce/tinymce/tinymce.min.js')
				);
		
		Asset::loadScript('dragon-wysiwyg', 'form/wysiwyg.js', ['jquery', 'dragon-tinymce']);
	}
}
