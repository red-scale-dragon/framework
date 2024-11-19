<?php

namespace Dragon\Core;

class Config {
	private static string $baseDir = "";
	private static string $pluginDirName = "";
	
	public static function setBaseDir(string $dir) {
		$dir = realpath($dir);
		if (!empty($dir)) {
			static::$baseDir = $dir;
		}
	}
	
	public static function getBaseDir() {
		return static::$baseDir;
	}
	
	public static function getPluginDirName() {
		$parts = explode('/', static::getBaseDir());
		return array_pop($parts);
	}
}
