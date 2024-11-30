<?php

if (!function_exists('outputs')) {
	function outputs(callable $callback) {
		ob_clean();
		$callback();
		$output = ob_get_contents();
		ob_clean();
		
		return $output;
	}
}
