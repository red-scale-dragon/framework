<?php

namespace Dragon\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Dragon\Support\Util;
use Dragon\Support\Url;

class Details extends SettingsController {
	protected static string $successNotice = "Saved.";
	protected string $modelName = "";
	
	protected array $emptyIsNullOnFields = [
		//
	];
	
	public function __construct() {
		static::$lastPage = Url::getAdminMenuLink(static::$parentSlug);
	}
	
	protected function saveItems(array $data) {
		if (empty($this->modelName)) {
			return;
		}
		
		$id = request('id');
		
		$filtered = [];
		foreach ($data as $key => $val) {
			if (in_array($key, $this->emptyIsNullOnFields) && empty($val)) {
				$filtered[Util::unnamespaced($key)] = null;
			} else {
				$filtered[Util::unnamespaced($key)] = str_replace('&quot;', '"', stripslashes($val));
			}
		}
		
		if (empty($id)) {
			$this->modelName::create($filtered);
		} else {
			$this->modelName::where('id', $id)->update($filtered);
		}
	}
	
	protected function getValue(?int $id, string $key, ?string $default = null) : ?string {
		if (empty($id) || empty($this->modelName)) {
			return $default;
		}
		
		$row = $this->modelName::find($id);
		return empty($row) ? $default : (string)$row->{$key};
	}
	
	protected function getFields(Request $request) {
		return [];
	}
}
