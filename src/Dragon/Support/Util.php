<?php

namespace Dragon\Support;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use Dragon\Core\Config;

class Util {
	public static function namespaced(string $key) : string {
		$prefix = Config::prefix();
		return $prefix . '_' . $key;
	}
	
	public static function unnamespaced(string $key) : string {
		$prefix = Config::prefix();
		$out = $key;
		if (strpos($key, $prefix) === 0) {
			$out = substr($key, strlen($prefix . '_'));
		}
		
		return $out;
	}
	
	public static function onlyDigits(string $text) : string {
		$out = "";
		
		for ($i=0; $i<strlen($text); $i++) {
			if (ctype_digit($text[$i])) {
				$out .= $text[$i];
			}
		}
		
		return $out;
	}
	
	public static function isEmail(string $email) : bool {
		if (is_email($email) === false) {
			return false;
		}
		
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * @throws \libphonenumber\NumberParseException
	 */
	public static function phoneFormat(?string $phoneNumber, int $format = PhoneNumberFormat::E164) : ?string {
		if (empty($phoneNumber)) {
			return null;
		}
		
		$util = PhoneNumberUtil::getInstance();
		return $util->format($phoneNumber, $format);
	}
	
	public static function ordinal(int $number) : ?string {
		$formatter = new \NumberFormatter('en_US', \NumberFormatter::ORDINAL);
		$formatted = $formatter->format($number);
		return $formatted === false ? null : $formatted;
	}
	
	public static function moneyFormat(?float $number) : ?string {
		if (empty($number)) {
			return null;
		}
		
		$formatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
		$formatted = $formatter->formatCurrency($number, 'USD');
		return $formatted === false ? null : $formatted;
	}
	
	public static function enumToList($enum) : array {
		$reflector = new \ReflectionClass($enum);
		$values = array_values($reflector->getConstants());
		return array_combine($values, $values);
	}
}
