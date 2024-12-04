<?php

namespace Dragon\Core;

use Dragon\Hooks\AdminPluginHooks;
use Dragon\Hooks\FrontendPluginHooks;
use Illuminate\Support\Facades\Artisan;
use Dragon\Database\Option;
use Dragon\Database\Migrate;
use Illuminate\Contracts\Debug\ExceptionHandler;
use App\Exceptions\Handler;
use Illuminate\Contracts\Http\Kernel;
use App\Http\Kernel as AppKernel;

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
		app()->singleton(ExceptionHandler::class, Handler::class);
		app()->singleton(Kernel::class, AppKernel::class);
	}
	
	public static function initWp() {
		if (empty(config('app.key'))) {
			static::generateEncryptionKey();
		}
		
		static::onActivation();
	}
	
	private static function generateEncryptionKey() {
		$base = Config::getBaseDir();
		$copyFrom = $base . '/.env.example';
		$copyTo = $base . '/.env';
		if (file_exists(realpath($copyFrom)) && file_exists(realpath($copyTo))) {
			copy($copyFrom, $copyTo);
		}
		
		Artisan::call('key:generate');
	}
	
	private static function onActivation() {
		if (Option::get('just_activated', 'no') === 'no') {
			return;
		}
		
		Migrate::up();
		Option::delete('just_activated');
	}
}
