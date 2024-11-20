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
		foreach ($controllers as $controller) {
			if (method_exists($controller, 'register')) {
				(new $controller)->register();
			}
		}
	}
}
