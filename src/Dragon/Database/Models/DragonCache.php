<?php

namespace Dragon\Database\Models;

use Illuminate\Database\Eloquent\Model;

class DragonCache extends Model {
	public $timestamps = false;
	
	protected $table = "dragonfw_cache";
	
	protected $casts = [
		'expiration'	=> 'int',
	];
}
