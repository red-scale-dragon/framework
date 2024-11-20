<?php

namespace Dragon\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Dragon\Core\Util;
use Illuminate\Support\Facades\App;

abstract class ShortcodeController extends Controller {
	protected static bool $shouldNamespace = true;
	protected static string $shortcodeTag = "";
	protected string $content = "";
	protected array $attributes = [];
	
	public static function register() {
		if (is_admin() || wp_is_json_request()) {
			return;
		}
		
		static::setup();
		$tag = static::$shortcodeTag;
		if (static::$shouldNamespace) {
			$tag = Util::namespaced(static::$shortcodeTag);
		}
		add_shortcode($tag, function ($attributes, $content) {
			
			$controller = App::make(static::class);
			$controller->attributes = $attributes;
			$controller->content = $content;
			
			return $controller->render(Request::capture());
		});
	}
	
	protected static function setup() {
		// Adjust properties programatically before setting the shortcode.
	}
}
