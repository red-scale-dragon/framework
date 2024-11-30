<?php

namespace Dragon\Core;

class Config {
	private static string $baseDir = "";
	private static string $pluginDirName = "";
	private static string $pluginLoaderFile = "";
	
	public static function setPluginLoaderFile(string $file) {
		static::$pluginLoaderFile = realpath($file);
		$dir = dirname(realpath($file));
		if (!empty($dir)) {
			static::$baseDir = $dir;
		}
	}
	
	public static function getBaseDir() : string {
		return static::$baseDir;
	}
	
	public static function getPluginDirName() : string {
		if (!empty(static::$pluginDirName)) {
			return static::$pluginDirName;
		}
		
		$parts = explode('/', static::getBaseDir());
		static::$pluginDirName = array_pop($parts);
		return static::$pluginDirName;
	}
	
	public static function getLoaderFilename() : string {
		return static::$pluginLoaderFile;
	}
	
	public static function prefix() : string {
		return static::get('app.namespace', 'dragonfw_' . static::getPluginDirName());
	}
	
	public static function dragonResourcesDir(string $extra = "", bool $htmlPath = false) : ?string {
		$path = realpath(__DIR__ . '/../../../resources/' . $extra);
		
		if ($path !== false && $htmlPath) {
			$path = '/wp-content/' . explode('wp-content/', $path)[1];
		}
		
		return $path === false ? null : $path;
	}
	
	public static function file(string $filename) : array {
		$file = realpath(static::getBaseDir() . '/config/' . $filename . '.php');
		return $file === false ? [] : require($file);
	}
	
	public static function get(string $key, $default = null) {
		$parts = explode('.', $key);
		$array = static::file(array_shift($parts));
		foreach ($parts as $key) {
			if (array_key_exists($key, $array)) {
				$array = $array[$key];
			} else {
				return $default;
			}
		}
		
		return $array;
	}
}
