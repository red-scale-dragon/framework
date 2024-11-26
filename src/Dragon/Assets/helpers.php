<?php

namespace Dragon\Assets;

use Dragon\Core\Config;

function image(string $name) : string {
	return assets_path('img/' . $name);
}

function css(string $name) : string {
	return assets_path('css/' . $name);
}

function js(string $name) : string {
	return assets_path('js/' . $name);
}

function assets_path(string $item = '') {
	return '/wp-content/plugins/' . Config::getPluginDirName() . '/resources/assets/' . $item;
}
