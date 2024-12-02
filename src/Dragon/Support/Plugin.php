<?php

namespace Dragon\Support;

use Dragon\Core\Config;

class Plugin {
	public static function getData() : ?string {
		$contents = file(Config::getLoaderFilename());
		$data = "";
		$hasStarted = false;
		foreach ($contents as $line) {
			if (strpos(trim($line), '/*') === 0) {
				$hasStarted = true;
				continue;
			}
			
			if (!$hasStarted) {
				continue;
			}
			
			if (substr(trim($line), -2) === '*/') {
				return $data;
			}
			
			$data .= trim(substr(trim($line), 1)) . PHP_EOL;
		}
		
		return null;
	}
}
