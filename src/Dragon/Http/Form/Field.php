<?php

namespace Dragon\Http\Form;

use Illuminate\Contracts\Encryption\DecryptException;

abstract class Field {
	protected string $name = "";
	protected array $attributes = [];
	protected ?string $label = "";
	protected ?string $value = "";
	protected bool $required = false;
	protected bool $encrypted = false;
	
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
	
	public function value(?string $value) : static {
		$this->value = $value;
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
		
		return $out;
	}
	
	public function getLabel() : ?string {
		return $this->label;
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
	
	protected function __construct(string $name) {
		$this->name = $name;
	}
	
	abstract public function render() : string;
}
