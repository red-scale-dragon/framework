<?php

namespace Dragon\Providers;

use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider
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
		foreach (config('roles.roles') as $slug => $data) {
			if ($slug === 'administrator') {
				$admin = get_role('administrator');
				foreach ($data['capabilities'] as $capability => $enabled) {
					if ($enabled) {
						$admin->add_cap($capability);
					} else {
						$admin->remove_cap($capability);
					}
				}
			} else {
				add_role($slug, $data['name'], $data['capabilities']);
			}
		}
	}
}
