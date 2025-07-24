<?php

namespace Dragon\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Dragon\Support\Util;
use Dragon\Assets\LoadsAssets;
use function Dragon\Http\send_cookie;

abstract class ShortcodeController extends Controller {
	use LoadsAssets;
	
	protected static bool $shouldNamespace = true;
	protected static string $shortcodeTag = "";
	protected static string $routeName = "";
	protected static bool $allowAdminAreaRequests = false;
	protected static bool $allowJsonRequests = false;
	
	public static function register() {
		if (!static::$allowAdminAreaRequests && is_admin()) {
			return;
		}
		
		if (!static::$allowJsonRequests && wp_is_json_request()) {
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
			
			foreach ($res->headers->getCookies() as $cookie) {
				send_cookie($cookie);
			}
			
			return $res->getContent();
		});
	}
	
	protected static function setup() {
		// Adjust properties programatically before setting the shortcode.
	}
}
