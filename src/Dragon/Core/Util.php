<?php

namespace Dragon\Core;

class Util {
	public static function namespaced(string $key) : string {
		$prefix = Config::prefix();
		return $prefix . $key;
	}
}
