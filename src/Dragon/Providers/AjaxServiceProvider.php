<?php

namespace Dragon\Providers;

use Illuminate\Support\ServiceProvider;
use Dragon\Support\Util;

class AjaxServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void {
		// ...
	}
	
	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void {
		foreach (config('hooks.ajax') as $slug => $data) {
			static::addAjaxHook('wp_ajax_' . Util::namespaced($slug),
					function () use ($data) {
						return $data['callback']();
					});
			
			if (!empty($data['frontend'])) {
				static::addAjaxHook('wp_ajax_nopriv_' . Util::namespaced($slug),
						function () use ($data) {
							return $data['callback']();
						});
			}
		}
	}
	
	public static function addAjaxHook(string $name, callable $callback) {
		add_action($name, function () use ($callback) {
			$response = $callback();
			if (is_array($response) || is_object($response)) {
				echo json_encode($response);
			} else {
				echo '{}';
			}
			
			wp_die();
		});
	}
}
