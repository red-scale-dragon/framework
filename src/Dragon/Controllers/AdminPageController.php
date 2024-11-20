<?php

namespace Dragon\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Dragon\Core\Util;
use Illuminate\Support\Facades\App;

abstract class AdminPageController extends Controller {
	protected static bool $shouldNamespace = true;
	protected static string $pageTitle = "";
	protected static string $menuText = "";
	protected static string $capability = "manage_options";
	protected static string $slug = "";
	protected static string $icon = "dashicons-admin-home";
	protected static string $parentSlug = "";
	protected static ?int $menuPosition = null;
	
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
		$controller = App::make(static::class);
		return $controller->render(Request::capture());
	}
	
	protected static function setup() {
		// Adjust properties programatically before setting the menu.
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
	
	private static function namespacedSlug(string $target = null) {
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
