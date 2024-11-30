<?php

namespace Dragon\Assets;

function image(string $name) : ?string {
	return Asset::dir('img/' . $name);
}

function css(string $name) : ?string {
	return Asset::dir('css/' . $name);
}

function js(string $name) : ?string {
	return Asset::dir('js/' . $name);
}
