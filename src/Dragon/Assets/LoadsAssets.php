<?php

namespace Dragon\Assets;

trait LoadsAssets {
	public static function loadPageAssets() {
		foreach (static::$scripts as $handle => $config) {
			$deps = empty($config['dependencies']) ? [] : $config['dependencies'];
			$inFooter = empty($config['in_footer']) ? true : (bool)$config['in_footer'];
			Asset::loadScript($handle, $config['script'], $deps, $inFooter);
		}
		
		foreach (static::$styles as $handle => $config) {
			$deps = empty($config['dependencies']) ? [] : $config['dependencies'];
			Asset::loadCss($handle, $config['style'], $deps);
		}
	}
}
