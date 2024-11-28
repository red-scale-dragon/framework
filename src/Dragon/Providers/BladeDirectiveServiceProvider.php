<?php

namespace Dragon\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Dragon\Support\Util;
use function Dragon\Http\nonce;
use Dragon\Support\User;

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
		Blade::directive('image', function (string $filename) {
			return \Dragon\Assets\image($filename);
		});
		
		Blade::directive('namespaced', function (string $key) {
			return Util::namespaced($key);
		});
		
		Blade::directive('nonce', function () {
			return '<?PHP if(1===1) echo \Dragon\Http\nonce(); ?>';
		});
	
		Blade::if('admin', function () {
			return User::isAdmin();
		});
	}
}
