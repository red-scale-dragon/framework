<?php

namespace Dragon\Providers;

use Illuminate\Support\ServiceProvider;

class ShortcodeServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		// ...
	}
	
	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		$controllers = config('shortcodes.controllers');
		foreach ($controllers as $controllerName) {
			$controller = new $controllerName();
			if (method_exists($controllerName, 'register')) {
				$controller->register();
			}
		}
	}
}
