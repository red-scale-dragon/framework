<?php

namespace Dragon\Core;

class Url {
	public static function getAssetsDirectory() : string {
		return '/wp-content/plugins/' . Config::getPluginDirName() . '/resources/assets';
	}
}
