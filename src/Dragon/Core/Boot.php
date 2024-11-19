<?php

namespace Dragon\Core;

use Dragon\Hooks\AdminPluginHooks;
use Dragon\Hooks\FrontendPluginHooks;
use Illuminate\Support\Facades\Artisan;

class Boot {
	public static function init() {
		if (is_admin()) {
			(new AdminPluginHooks())->init();
		} else {
			(new FrontendPluginHooks())->init();
		}
	}
	
	public static function bootAcorn() {
		\Roots\bootloader()->boot();
	}
	
	public static function initWp() {
		if (empty(config('app.key'))) {
			static::generateEncryptionKey();
		}
		// All business logic happens now.
	}
	
	private static function generateEncryptionKey() {
		$base = Config::getBaseDir();
		$copyFrom = $base . '/.env.example';
		$copyTo = $base . '/.env';
		if (!file_exists(realpath($copyFrom))) {
			return;
		}
		
		if (!file_exists(realpath($copyTo))) {
			copy($copyFrom, $copyTo);
		}
		
		Artisan::call('key:generate');
	}
}