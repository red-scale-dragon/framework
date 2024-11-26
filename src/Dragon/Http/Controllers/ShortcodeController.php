<?php

namespace Dragon\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Dragon\Support\Util;
use Dragon\Assets\LoadsAssets;

abstract class ShortcodeController extends Controller {
	use LoadsAssets;
	
	protected static bool $shouldNamespace = true;
	protected static string $shortcodeTag = "";
	protected static string $routeName = "";
	
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
			$request = Request::capture();
			
			$url = route(static::$routeName, $request->all(), false);
			$req = Request::create(
				$url,
				$request->getMethod(),
				$request->all(),
				$request->cookies->all(),
				$request->files->all(),
				$request->server->all()
			);
			$req->attributes->add([
				'attributes' => $attributes,
				'content' => $content,
				'url' => $request->getUri(),
			]);
			
			$res = app()->handle($req);
			return $res->getContent();
		});
	}
	
	protected static function setup() {
		// Adjust properties programatically before setting the shortcode.
	}
}
