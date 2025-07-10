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
	public function boot(): void {
		$this->removeRoles();
		$this->addRoles();
	}
	
	private function removeRoles() {
		foreach (config('roles.remove_roles') as $slug) {
			if ($slug === 'administrator') {
				continue;
			}
			
			remove_role($slug);
		}
	}
	
	private function addRoles() {
		foreach (config('roles.roles') as $slug => $data) {
			if ($slug === 'administrator') {
				$admin = get_role('administrator');
				$this->addNewCapabilities($admin, $data['capabilities']);
			} else {
				$existingRole = get_role($slug);
				if (!empty($existingRole)) {
					$this->removeAllCapabilities($existingRole);
					$this->addNewCapabilities($existingRole, $data['capabilities']);
				} else {
					add_role($slug, $data['name'], $data['capabilities']);
				}
			}
		}
	}
	
	private function removeAllCapabilities(\WP_Role $role) {
		foreach ($role->capabilities as $cap => $enabled) {
			$role->remove_cap($cap);
		}
	}
	
	private function addNewCapabilities(\WP_Role $role, array $capabilites) {
		foreach ($capabilites as $capability => $enabled) {
			if ($enabled) {
				$role->add_cap($capability);
			} else {
				$role->remove_cap($capability);
			}
		}
	}
}
