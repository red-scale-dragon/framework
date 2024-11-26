<?php

namespace Dragon\Http;

use Dragon\Support\Util;

function nonce() {
	$nonce = wp_create_nonce(Util::namespaced('nonce'));
	return '<input name="' . Util::namespaced('nonce') . '" value="' . $nonce . '" type="hidden" />';
}
