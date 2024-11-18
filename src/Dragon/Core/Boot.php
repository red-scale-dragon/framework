<?php

namespace Dragon\Core;

use Dragon\Hooks\AdminPluginHooks;
use Dragon\Hooks\FrontendPluginHooks;

class Boot {
	public static function init() {
		if (is_admin()) {
			(new AdminPluginHooks())->init();
		} else {
			(new FrontendPluginHooks())->init();
		}
	}
	
	public static function bootAcorn() {
		\Roots\bootloader()->boot();
	}
}
