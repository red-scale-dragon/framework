<?php

namespace Dragon\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Dragon\Support\Util;
use Dragon\Assets\LoadsAssets;
use function Dragon\Http\send_cookie;

abstract class AdminPageController extends Controller {
	use LoadsAssets;
	
	protected static bool $shouldNamespace = true;
	protected static string $pageTitle = "";
	protected static string $menuText = "";
	protected static string $capability = "manage_options";
	protected static string $slug = "";
	protected static string $icon = "dashicons-admin-home";
	protected static string $parentSlug = "";
	protected static ?int $menuPosition = null;
	protected static string $routeName = "";
	
	public static function register() {
		if (!is_admin() || wp_is_json_request()) {
			return;
		}
		
		static::setup();
		$isMainMenu = in_array(static::class, config('admin_menu.menu'));
		if ($isMainMenu) {
			static::addMenuPage();
		} else {
			static::addSubmenuPage();
		}
	}
	
	public static function pageCallback() {
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
		
		$res = app()->handle($req);
		
		foreach ($res->headers->getCookies() as $cookie) {
			send_cookie($cookie);
		}
		
		echo $res->getContent();
	}
	
	protected static function setup() {
		// Adjust properties programatically before setting the menu.
	}
	
	protected function makePageData(Request $request, array $extraData = []) {
		$data = [
			'title' => static::$pageTitle,
		];
		
		return array_merge($data, $extraData);
	}
	
	private static function addMenuPage() {
		add_menu_page(
				static::$pageTitle,
				static::$menuText,
				static::$capability,
				static::namespacedSlug(),
				[static::class, 'pageCallback'],
				static::$icon,
				static::$menuPosition
		);
	}
	
	private static function namespacedSlug(string $target = null) : string {
		$slug = empty($target) ? static::$slug : $target;
		if (static::$shouldNamespace) {
			$slug = Util::namespaced($slug);
		}
		
		return $slug;
	}
	
	private static function addSubmenuPage() {
		$parent = empty(static::$parentSlug) ? "" : static::namespacedSlug(static::$parentSlug);
		add_submenu_page(
				$parent,
				static::$pageTitle,
				static::$menuText,
				static::$capability,
				static::namespacedSlug(),
				[static::class, 'pageCallback'],
				static::$menuPosition
		);
	}
}
