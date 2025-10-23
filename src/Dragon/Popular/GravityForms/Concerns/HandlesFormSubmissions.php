<?php

namespace Dragon\Popular\GravityForms\Concerns;

use Dragon\Database\Option;

trait HandlesFormSubmissions {
	protected array $form = [];
	protected array $entry = [];
	
	private array $callbacks = [
// 		'settings_key' => 'method_name',
	];
	
	public static function handleFormSubmission(array $entry, array $form) {
		$that = new static();
		$that->form = $form;
		$that->entry = $entry;
		foreach ($that->callbacks as $key => $method) {
			if ($that->isFormOfType($key)) {
				$that->{$method}();
			}
		}
	}
	
	protected function rgar(string $key, string $suffix = null, $default = null) {
		$gfKey = Option::get($key);
		if (!is_null($suffix)) {
			$gfKey .= '.' . $suffix;
		}
		
		return rgar($this->entry, $gfKey, $default);
	}
	
	private function isFormOfType(string $key) {
		return (int)Option::get($key) === (int)$this->form['id'];
	}
}
