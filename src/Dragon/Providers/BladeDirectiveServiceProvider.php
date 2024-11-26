<?php

namespace Dragon\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Dragon\Support\Util;
use function Dragon\Http\nonce;

class BladeDirectiveServiceProvider extends ServiceProvider
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
		Blade::directive('image', function (string $expression) {
			return \Dragon\Assets\image($expression);
		});
		
		Blade::directive('namespaced', function (string $expression) {
			return Util::namespaced($expression);
		});
		
		Blade::directive('nonce', function () {
			return nonce();
		});
	}
}
