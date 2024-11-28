<?php

namespace Dragon\Hooks;

use Dragon\Core\Boot;
use Dragon\Core\Config;

class FrontendPluginHooks extends PluginHooksAbstract {
	public function init () {
		$this->actions = array_merge_recursive($this->actions, Config::get('hooks.frontend.actions', []));
		$this->filters = array_merge_recursive($this->filters, Config::get('hooks.frontend.filters', []));
		
		parent::init();
	}
}
