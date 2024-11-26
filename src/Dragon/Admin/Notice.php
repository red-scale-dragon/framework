<?php

namespace Dragon\Admin;

class Notice {
	const ERROR_INVALID_NONCE = 'An invalid nonce was supplied for the form. Try refreshing the page and reentering your information.';
	
	public static function error($message) {
		static::makeNotice('error', $message);
	}
	
	public static function success($message) {
		static::makeNotice('success', $message);
	}
	
	public static function makeNotice($type, $message) {
		wp_admin_notice($message, ['type' => $type]);
	}
}
