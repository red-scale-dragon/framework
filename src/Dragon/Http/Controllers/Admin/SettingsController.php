<?php

namespace Dragon\Http\Controllers\Admin;

use Dragon\Http\Controllers\AdminPageController;
use Dragon\Admin\Notice;
use Illuminate\Http\Request;
use Dragon\Database\Option;
use Dragon\Http\Form\Select;
use Illuminate\Foundation\Http\FormRequest;

class SettingsController extends AdminPageController {
	protected static string $successNotice = "Settings saved.";
	protected static string $pageTitle = "Admin Settings";
	protected static string $menuText = "Dragon Settings";
	protected static string $capability = "manage_options";
	protected static string $routeName = "admin-settings";
	protected static string $slug = "settings";
	protected static string $lastPage = "";
	protected static bool $readOnly = false;
	protected string $view = "admin.settings";
	
	protected array $encryptedFields = [
		'test_field',
	];
	
	public function show(Request $request) {
		return view($this->view, $this->makePageData($request, [
			'fields'	=> $this->getFields($request),
			'last_page'	=> static::$lastPage,
			'read_only'	=> (static::$readOnly && !empty($request->get('id'))),
		]));
	}
	
	protected function save(FormRequest $request) {
		if ($request->attributes->get('nonce_invalid')) {
			return $this->show($request);
		}
		
		$saveThese = [];
		foreach ($request->validated() as $key => $val) {
			if (in_array($key, $this->encryptedFields)) {
				$val = encrypt($val);
			}
			
			$saveThese[$key] = $val;
		}
		
		$this->saveItems($saveThese);
		$this->afterSaving($request);
		
		Notice::success(static::$successNotice);
		
		return $this->show($request);
	}
	
	protected function afterSaving(Request $request) {
		//
	}
	
	protected function saveItems(array $data) {
		foreach ($data as $key => $val) {
			Option::set($key, stripslashes($val));
		}
	}
	
	protected function getFields(Request $request) {
		return [
			"Plugin Settings",
			
			Select::make('remove_migrations_on_deactivation')
			->options([
				'no' => 'No (Recommended)',
				'yes' => 'Yes',
			])
			->value(Option::get('remove_migrations_on_deactivation'))
			->label('Remove DB tables on deactivation?')
			->required(),
		];
	}
}
