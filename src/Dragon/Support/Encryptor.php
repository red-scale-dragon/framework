<?php

namespace Dragon\Support;

use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Contracts\Encryption\DecryptException;

class Encryptor {
	public static function encrypt(?string $data) : ?string {
		if (empty($data)) {
			return null;
		}
		
		try {
			return encrypt($data);
		} catch (EncryptException $e) {
			return null;
		}
	}
	
	public static function decrypt(?string $data) : ?string {
		if (empty($data)) {
			return null;
		}
		
		try {
			return decrypt($data);
		} catch (DecryptException $e) {
			return null;
		}
	}
}
