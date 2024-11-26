<?php

namespace Dragon\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserMeta extends Model {
	public $timestamps = false;
	
	protected $table = "usermeta";
	protected $primaryKey = 'umeta_id';
	
	protected $casts = [
		'user_id'	=> 'int',
	];
	
	public function user() : HasOne {
		return $this->hasOne(User::class);
	}
}
