<?php

namespace Dragon\Hooks;

use Dragon\Database\Migrate;
use Dragon\Database\Option;
use Dragon\Core\Config;
use Dragon\Support\Util;
use Dragon\Admin\Table;

class AdminPluginHooks extends PluginHooksAbstract {
	public function init () {
		$this->actions['admin_menu'][] = [
			'callback' => [static::class, 'buildAdminMenu'],
		];
		
		$this->actions['wp_ajax_' .  Util::namespaced('table_delete')][] = [
			'callback' => [Table::class, 'handleTableRowDelete'],
		];
		
		$this->actions = array_merge_recursive($this->actions, Config::get('hooks.admin.actions', []));
		$this->filters = array_merge_recursive($this->filters, Config::get('hooks.admin.filters', []));
		
		parent::init();
	}
	
	public static function onActivation() {
		Option::set('just_activated', 'yes');
	}
	
	public static function onDeactivation() {
		if (Option::get('remove_migrations_on_deactivation', 'no') === 'yes') {
			Migrate::removeDatabaseTables();
		}
		
		foreach (config('cron.actions') as $hook => $data) {
			wp_clear_scheduled_hook($hook);
		}
		
		$hooks = Config::get('hooks.deactivation', []);
		foreach ($hooks as $callback) {
			$callback();
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
