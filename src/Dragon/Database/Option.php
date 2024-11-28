<?php

namespace Dragon\Database;

use Dragon\Support\Util;

class Option {
	public static function get(string $key, $default = null) {
		return get_option(Util::namespaced($key), $default);
	}
	
	public static function set(string $key, ?string $value) {
		update_option(Util::namespaced($key), $value);
	}
	
	public static function delete(string $key) {
		delete_option(Util::namespaced($key));
	}
}
