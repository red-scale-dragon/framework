<?php

namespace Dragon\Support;

class Cookie {
	public static function set(string $key, string $content, string $secure = true) {
		setcookie(
			name: $key,
			value: $content,
			secure: $secure,
		);
	}
	
	public static function get(string $key, mixed $default) : mixed {
		return $_COOKIE[$key] ?? $default;
	}
}
