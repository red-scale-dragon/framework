<?php

namespace Dragon\Assets;

trait LoadsAssets {
	protected static array $scripts = [];
	protected static array $styles = [];
	
	public static function loadPageAssets() {
		foreach (static::$scripts as $handle => $config) {
			$deps = empty($config['dependencies']) ? [] : $config['dependencies'];
			$inFooter = array_key_exists('in_footer', $config) ? $config['in_footer'] : true;
			$useVersioning = array_key_exists('use_versioning', $config) ? $config['use_versioning'] : true;
			Asset::loadScript($handle, $config['script'], $deps, $inFooter, $useVersioning);
		}
		
		foreach (static::$styles as $handle => $config) {
			$deps = empty($config['dependencies']) ? [] : $config['dependencies'];
			Asset::loadCss($handle, $config['style'], $deps);
		}
	}
}
