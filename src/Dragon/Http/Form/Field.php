<?php

namespace Dragon\Http\Form;

use Illuminate\Contracts\Encryption\DecryptException;

abstract class Field {
	protected string $name = "";
	protected array $attributes = [];
	protected ?string $label = "";
	protected ?string $description = "";
	protected ?string $value = "";
	protected array $valueArray = [];
	protected ?string $readOnlyValue = "";
	protected bool $required = false;
	protected bool $encrypted = false;
	protected bool $readOnly = false;
	
	public static function make(string $name) : static {
		return new static($name);
	}
	
	public function attributes(array $attributes) : static {
		$this->attributes = $attributes;
		return $this;
	}
	
	public function label(string $label) : static {
		$this->label = $label;
		return $this;
	}
	
	public function description(string $description) : static {
		$this->description = $description;
		return $this;
	}
	
	public function value(?string $value) : static {
		$this->value = stripslashes($value);
		return $this;
	}
	
	public function valueArray(array $value) : static {
		$this->valueArray = $value;
		return $this;
	}
	
	public function valueReadOnly(?string $value) : static {
		$this->readOnlyValue = $value;
		return $this;
	}
	
	public function required(bool $isRequired = true) : static {
		$this->required = $isRequired;
		return $this;
	}
	
	public function encrypted(bool $isEncrypted = true) : static {
		$this->encrypted = $isEncrypted;
		return $this;
	}
	
	public function readOnly(bool $isReadOnly = true) : static {
		$this->readOnly = $isReadOnly;
		return $this;
	}
	
	public function isReadOnly() : bool {
		return $this->readOnly;
	}
	
	public function getName() : string {
		return $this->name;
	}
	
	public function getValue() : ?string {
		$out = $this->value;
		if ($this->isEncrypted()) {
			try {
				$out = decrypt($out);
			} catch (DecryptException $e) {
				//
			}
		}
		
		return str_replace('"', '&quot;', $out);
	}
	
	public function getValueArray() : array {
		return $this->valueArray;
	}
	
	public function getValueReadOnly() : ?string {
		if (!is_null($this->readOnlyValue)) {
			return $this->readOnlyValue;
		}
		
		if (!is_null($this->getValue())) {
			return $this->getValue();
		}
		
		if (!empty($this->getValueArray())) {
			return implode(", ", $this->getValueArray());
		}
		
		return null;
	}
	
	public function getLabel() : ?string {
		return $this->label;
	}
	
	public function getDescription() : ?string {
		return $this->description;
	}
	
	public function getAttributes() : array {
		return $this->attributes;
	}
	
	public function isRequired() : bool {
		return $this->required;
	}
	
	public function isEncrypted() : bool {
		return $this->encrypted;
	}
	
	public function render() : string {
		if ($this->isReadOnly()) {
			return (string)$this->getValueReadOnly();
		}
		
		return $this->toHtml();
	}
	
	protected function __construct(string $name) {
		$this->name = $name;
	}
	
	abstract protected function toHtml() : string;
}
