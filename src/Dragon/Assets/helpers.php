<?php

namespace Dragon\Assets;

use Dragon\Core\Url;

function image(string $name) {
	return Url::getAssetsDirectory() . '/img/' . $name;
}
