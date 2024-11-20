<?php

namespace Dragon\Hooks;

use Dragon\Database\Migrate;
use Dragon\Database\Option;

class AdminPluginHooks extends PluginHooksAbstract {
	public function init () {
		$this->actions['admin_menu'][] = [
			'callback' => [static::class, 'buildAdminMenu'],
		];
		
		parent::init();
	}
	
	public static function onActivation() {
		Option::set('just_activated', 'yes');
	}
	
	public static function onDeactivation() {
		if (Option::get('remove_migrations_on_deactivation', 'no') === 'yes') {
			Migrate::removeDatabaseTables();
		}
	}
	
	public static function buildAdminMenu(): void {
		$types = ['menu', 'submenu', 'hidden_menu'];
		foreach ($types as $item) {
			$controllers = config('admin_menu.' . $item);
			foreach ($controllers as $controller) {
				if (method_exists($controller, 'register')) {
					(new $controller)->register();
				}
			}
		}
	}
}
