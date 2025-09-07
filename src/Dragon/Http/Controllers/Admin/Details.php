<?php

namespace Dragon\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Dragon\Core\Config;
use Dragon\Support\User;
use Dragon\Support\Util;
use Dragon\Support\Url;
use Illuminate\Database\Eloquent\Model;

class Details extends SettingsController {
	protected static string $successNotice = "Saved.";
	protected string $modelName = "";
	protected ?string $requiredQueryParam = null;
	protected ?string $requiredQueryValue = null;
	protected ?Model $currentRow = null;
	
	protected array $emptyIsNullOnFields = [
		//
	];
	
	public function __construct() {
		$this->requiredQueryValue = Cache::get(Config::prefix() . '_' . User::getUserId() . '_' . $this->requiredQueryParam);
		$query = [];
		if (!empty($this->requiredQueryValue)) {
			$query = [
				$this->requiredQueryParam => $this->requiredQueryValue,
			];
		}
		
		static::$lastPage = Url::getAdminMenuLink(static::$parentSlug, $query);
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
			} else if (is_array($val)) {
				$filtered[Util::unnamespaced($key)] = $val;
			} else {
				$filtered[Util::unnamespaced($key)] = str_replace('&quot;', '"', stripslashes((string)$val));
			}
		}
		
		$filtered = $this->modifySaveData($filtered);
		
		if (empty($id)) {
			$this->currentRow = $this->modelName::create($filtered);
		} else {
			$this->modelName::where('id', $id)->update($filtered);
			$this->currentRow = $this->modelName::find($id);
		}
	}
	
	protected function modifySaveData(array $filtered) {
		return $filtered;
	}
	
	protected function getValue(?int $id, string $key, ?string $default = null, bool $useDefaultOnNull = false) : ?string {
		if (empty($id) || empty($this->modelName)) {
			return $default;
		}
		
		$row = $this->modelName::find($id);
		$value = empty($row) ? $default : (string)$row->{$key};
		return (is_null($value) || $value === '') && $useDefaultOnNull ? $default : $value;
	}
	
	protected function getArrayValue(?int $id, string $key, array $default = []) : array {
		if (empty($id) || empty($this->modelName)) {
			return $default;
		}
		
		$row = $this->modelName::find($id);
		return empty($row) ? $default : (array)$row->{$key};
	}
	
	protected function getFields(Request $request) {
		return [];
	}
}
