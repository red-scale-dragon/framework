<?php

namespace Dragon\Support;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use Dragon\Core\Config;

class Util {
	public static function anyEmpty(array $items) : bool {
		foreach ($items as $item) {
			if (empty($item)) {
				return true;
			}
		}
		
		return false;
	}
	
	public static function firstNonEmpty(array $items) : mixed {
		foreach ($items as $item) {
			if (!empty($item)) {
				return $item;
			}
		}
		
		return null;
	}
	
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
	
	public static function onlyDigits(string $text, bool $allowDecimal = false) : string {
		$out = "";
		
		for ($i=0; $i<strlen($text); $i++) {
			if (ctype_digit($text[$i]) || ($allowDecimal && $text[$i] === '.')) {
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
	public static function phoneFormat(
			?string $phoneNumber,
			string $region = 'US',
			int $format = PhoneNumberFormat::E164) : ?string {
				
				if (empty($phoneNumber)) {
					return null;
				}
				
				$util = PhoneNumberUtil::getInstance();
				$phoneNumberObj = $util->parse($phoneNumber, $region);
				return $util->format($phoneNumberObj, $format);
	}
	
	public static function nth(float $number) : ?string {
		$formatter = new \NumberFormatter('en_US', \NumberFormatter::ORDINAL);
		$formatted = $formatter->format($number);
		return $formatted === false ? null : $formatted;
	}
	
	public static function moneyFormat(?float $number, string $currency = "USD") : ?string {
		if (!is_numeric($number)) {
			return null;
		}
		
		$formatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
		$formatted = $formatter->formatCurrency($number, $currency);
		return $formatted === false ? null : $formatted;
	}
}
