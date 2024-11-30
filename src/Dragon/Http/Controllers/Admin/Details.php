<?php

namespace Dragon\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Dragon\Support\Util;

class Details extends SettingsController {
	protected static string $successNotice = "Saved.";
	protected string $modelName = "";
	
	protected function saveItems(array $data) {
		if (empty($this->modelName)) {
			return;
		}
		
		$id = request('id');
		
		$filtered = [];
		foreach ($data as $key => $val) {
			$filtered[Util::unnamespaced($key)] = $val;
		}
		
		if (empty($id)) {
			$this->modelName::create($filtered);
		} else {
			$this->modelName::where('id', $id)->update($filtered);
		}
	}
	
	protected function getValue(?int $id, string $key) : ?string {
		if (empty($id) || empty($this->modelName)) {
			return null;
		}
		
		$row = $this->modelName::find($id);
		return empty($row) ? null : (string)$row->{$key};
	}
	
	protected function getFields(Request $request) {
		return [];
	}
}
