<?php

namespace Dragon\Hooks;

use Dragon\Core\Boot;
use Dragon\Core\Config;

abstract class PluginHooksAbstract {
	protected array $actions = [
		//
	];
	
	protected array $filters = [
		//
	];
	
	public function init() {
		if (is_admin()) {
			register_activation_hook(Config::getLoaderFilename(), [AdminPluginHooks::class, 'onActivation']);
			register_deactivation_hook(Config::getLoaderFilename(), [AdminPluginHooks::class, 'onDeactivation']);
		}
		
		$this->actions['after_setup_theme'][] = [
			'callback' => [Boot::class, 'bootAcorn'],
			'priority' => 0,
		];
		
		$this->actions['init'][] = [
			'callback' => [Boot::class, 'initWp'],
		];
		
		$this->actions = array_merge_recursive($this->actions, Config::get('hooks.global.actions', []));
		$this->filters = array_merge_recursive($this->filters, Config::get('hooks.global.filters', []));
		
		$this->enqueueItems('add_action', $this->actions);
		$this->enqueueItems('add_filter', $this->filters);
	}
	
	public function getActions() {
		return $this->actions;
	}
	
	public function getFilters() {
		return $this->filters;
	}
	
	private function enqueueItems(string $functionName, array $items) {
		foreach ($items as $hookName => $handlers) {
			foreach ($handlers as $config) {
				$args = empty($config['args']) ? 1: (int)$config['args'];
				$priority = empty($config['priority']) ? 10: (int)$config['priority'];
				call_user_func($functionName, $hookName, $config['callback'], $priority, $args);
			}
		}
	}
}
