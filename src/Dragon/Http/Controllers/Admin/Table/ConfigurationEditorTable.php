<?php

namespace Dragon\Http\Controllers\Admin\Table;

use Dragon\Http\Controllers\Admin\Table;
use DirectoryIterator;
use Dragon\Core\Config;
use Illuminate\Support\Str;

class ConfigurationEditorTable extends Table {
	protected static string $pageTitle = "Config Editor";
	protected static string $menuText = "Config Editor";
	protected static string $capability = "manage_options";
	protected static string $routeName = "admin-config-editor";
	protected static string $slug = "admin-config-editor";
	protected static string $parentSlug = "settings";
	
	protected bool $canRead = true;
	protected bool $canUpdate = true;
	
	protected string $detailsSlug = "admin-config-editor-details";
	
	protected array $headers = [
		'filename'	=> 'Filename',
		'name'		=> 'Name',
	];
	
	protected function getRows() {
		$rows = [];
		foreach (new DirectoryIterator(Config::getBaseDir() . '/config') as $fileInfo) {
			if ($fileInfo->isDot()) {
				continue;
			}
			$filename = $fileInfo->getFilename();
			
			$object = new \stdClass();
			$object->id = $filename;
			$object->filename = $filename;
			$object->name = Str::title(str_replace(['.php', '_'], ['', ' '], $filename));
			$rows[] = $object;
		}
		
		return collect($rows);
	}
}
