<?php

namespace Dragon\Assets;

use Dragon\Support\Util;
use Dragon\Support\Url;

class Asset {
	private static bool $enabledAjax = false;
	
	public static function enableFrontendAjax(string $beforeHandle) {
		if (static::$enabledAjax) {
			return;
		}
		
		wp_add_inline_script(
			Util::namespaced($beforeHandle),
			'let ajax_url = "' . admin_url('admin-ajax.php') . '";',
			'before'
		);
		
		static::$enabledAjax = true;
	}
	
	public static function loadScript(
		string $handle, string $script, array $dependencies = ['jquery'], bool $inFooter = true) {
		
		if (!Url::isUrl($script)) {
			$script = js($script);
		}
			
		wp_enqueue_script(Util::namespaced($handle), $script, $dependencies, true, $inFooter);
	}
	
	public static function loadCss(string $handle, string $css, array $dependencies = []) {
		if (!Url::isUrl($css)) {
			$css = css($css);
		}
		
		wp_enqueue_style(Util::namespaced($handle), $css, $dependencies, true);
	}
}
