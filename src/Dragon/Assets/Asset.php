<?php

namespace Dragon\Assets;

use Dragon\Support\Util;
use Dragon\Support\Url;
use Dragon\Core\Config;

class Asset {
	private static bool $enabledAjax = false;
	
	public static function dir(string $extra = "") : ?string {
		$path = realpath(__DIR__ . '/../../../../../../resources/assets/' . $extra);
		
		if ($path !== false) {
			return '/wp-content/' . explode('wp-content/', $path)[1];
		}
		
		return Config::dragonResourcesDir('assets/' . $extra, true);
	}
	
	public static function enableFrontendAjax(string $beforeHandle, bool $shouldNamespace = true) {
		if (static::$enabledAjax) {
			return;
		}
		
		$beforeHandle = $shouldNamespace ? Util::namespaced($beforeHandle) : $beforeHandle;
		wp_add_inline_script(
			$beforeHandle,
			'let ajax_url = "' . admin_url('admin-ajax.php') . '";',
			'before'
		);
		
		static::$enabledAjax = true;
	}
	
	public static function loadScript(
		string $handle, string $script, array $dependencies = ['jquery'], bool $inFooter = true) {
		
		if (!Url::isUrl($script) && !Url::isUrl($script, '//')) {
			$script = js($script);
		}
		
		wp_enqueue_script(Util::namespaced($handle), $script, static::namespacedDeps($dependencies), true, $inFooter);
	}
	
	public static function loadCss(string $handle, string $css, array $dependencies = []) {
		if (!Url::isUrl($css) && !Url::isUrl($css, '//')) {
			$css = css($css);
		}
		
		wp_enqueue_style(Util::namespaced($handle), $css, static::namespacedDeps($dependencies), true);
	}
	
	public static function namespacedDeps(array $deps) {
		$out = [];
		foreach ($deps as $item) {
			if ($item !== 'jquery') {
				$item = Util::namespaced($item);
			}
			
			$out[] = $item;
		}
		
		return $out;
	}
}
