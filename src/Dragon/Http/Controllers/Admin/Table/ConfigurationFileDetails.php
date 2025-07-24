<?php

namespace Dragon\Http\Controllers\Admin\Table;

use Dragon\Core\Config;
use Illuminate\Http\Request;
use Dragon\Http\Controllers\Admin\Details;
use Dragon\Http\Form\CodeEditor;
use Dragon\Http\Requests\Admin\ConfigurationFileRequest;

class ConfigurationFileDetails extends Details {
	protected static string $pageTitle = "Config File Details";
	protected static string $menuText = "Config File Details";
	protected static string $capability = "manage_options";
	protected static string $routeName = "admin-config-editor-details";
	protected static string $slug = "admin-config-editor-details";
	protected static string $parentSlug = "admin-config-editor";
	
	protected static array $styles = [
		'dragonfw-highlightjs' => [
			'style' => 'https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/styles/default.min.css',
		],
		'dragonfw-highlighter' => [
			'style' => 'https://cdn.jsdelivr.net/gh/WebCoder49/code-input@2.5/code-input.min.css',
		],
	];
	
	protected static array $scripts = [
		'dragonfw-highlightjs' => [
			'script' => 'https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/highlight.min.js',
		],
		'dragonfw-highlightjs-language' => [
			'script' => 'https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/languages/php.min.js',
			'dependencies' => [
				'dragonfw-highlightjs',
			],
		],
		'dragonfw-highlighter' => [
			'script' => 'https://cdn.jsdelivr.net/gh/WebCoder49/code-input@2.5/code-input.min.js',
			'dependencies' => [
				'dragonfw-highlightjs-language',
			],
		],
		'dragonfw-code-editor' => [
			'script' => '/form/code-editor.js',
			'dependencies' => [
				'dragonfw-highlighter',
			],
		],
	];
	
	public function show(Request $request) {
		static::loadPageAssets();
		return parent::show($request);
	}
	
	public function store(ConfigurationFileRequest $request) {
		return $this->save($request);
	}
	
	protected function getFields(Request $request) {
		$filename = Config::getBaseDir() . '/config/' . request('id');
		return [
			CodeEditor::make('file_contents')
				->value(str_replace('\\', '\\\\', file_get_contents($filename)))
				->label('File Contents')
				->required()
				->description('WARNING: Changing this config file will have ' .
					'consequences! You could break your site, block this page ' .
					'from loading preventing repairs, or create other disasters. ' .
					'Not all settings may be used by your particular plugin. ' .
					'Incorrect data types/structure or invalid formatting will ' .
					'also break your site. Only change this file if you know ' .
					'what you are doing.'),
		];
	}
	
	protected function saveItems(array $data) {
		$filename = Config::getBaseDir() . '/config/' . request('id');
		file_put_contents($filename, str_replace([
			'<!--?php',
			'-->',
			"\'",
			'&quot;',
			'\\\\',
			'\\"',
		], [
			'<?php',
			'>',
			"'",
			'"',
			'\\',
			'"',
		], $data['file_contents']));
	}
}
