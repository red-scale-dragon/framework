<?php

namespace Dragon\Http;

use Dragon\Support\Util;
use Symfony\Component\HttpFoundation\Cookie;

function nonce() {
	$nonce = wp_create_nonce(Util::namespaced('nonce'));
	return '<input name="' . Util::namespaced('nonce') . '" value="' . $nonce . '" type="hidden" />';
}

function send_cookie(Cookie $cookie) {
	setcookie(
		$cookie->getName(),
		$cookie->getValue(),
		$cookie->getExpiresTime(),
		$cookie->getPath(),
		$cookie->getDomain(),
		$cookie->isSecure(),
		$cookie->isHttpOnly()
	);
}
