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
		return (string)config('app.namespace');
	}
}
