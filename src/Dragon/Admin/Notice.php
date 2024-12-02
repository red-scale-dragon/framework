<?php

namespace Dragon\Admin;

class Notice {
	const ERROR_INVALID_NONCE = 'An invalid nonce was supplied for the form. Try refreshing the page and reentering your information.';
	
	public static function error(string $message) {
		static::makeNotice('error', $message);
	}
	
	public static function success(string $message) {
		static::makeNotice('success', $message);
	}
	
	public static function makeNotice(string $type, string $message) {
		wp_admin_notice($message, ['type' => $type]);
	}
}
