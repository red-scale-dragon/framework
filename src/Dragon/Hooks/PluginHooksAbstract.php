<?php

namespace Dragon\Hooks;

use Dragon\Core\Boot;

abstract class PluginHooksAbstract {
	protected array $actions = [
		//
	];
	
	protected array $filters = [
		//
	];
	
	public function init() {
		$this->actions['after_setup_theme'][] = [
			'callback' => [Boot::class, 'bootAcorn'],
			'priority' => 0,
		];
		
		$this->actions['init'][] = [
			'callback' => [Boot::class, 'initWp'],
		];
		
		$this->enqueueItems('add_action', $this->actions);
		$this->enqueueItems('add_filter', $this->filters);
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
