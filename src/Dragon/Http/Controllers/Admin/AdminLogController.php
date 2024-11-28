<?php

namespace Dragon\Http\Controllers\Admin;

use Dragon\Http\Controllers\AdminPageController;
use Illuminate\Http\Request;
use Dragon\Core\Config;
use Dragon\Http\Form\Textarea;

class AdminLogController extends AdminPageController {
	protected static string $pageTitle = "Log";
	protected static string $menuText = "Log";
	protected static string $capability = "manage_options";
	protected static string $routeName = "admin-log";
	protected static string $slug = "log";
	protected static string $parentSlug = "settings";
	
	public function show(Request $request) {
		$logContents = (string)file_get_contents($this->getLogFilename());
		
		$data = [
			'title' => static::$pageTitle,
			'log' => Textarea::make('log')
					->value($logContents)
					->attributes([
						'rows' => 30,
						'cols' => 150,
					]),
		];
		
		if ($request->attributes->has('notice')) {
			$data['notice'] = $request->attributes->get('notice');
		}
		
		return view('admin.log', $data);
	}
	
	public function clear(Request $request) {
		if ($request->attributes->get('nonce_invalid')) {
			return $this->show($request);
		}
		
		file_put_contents($this->getLogFilename(), '');
		
		return $this->show($request);
	}
	
	private function getLogFilename() {
		return realpath(Config::getBaseDir() . '/storage/logs/application.log');
	}
}
