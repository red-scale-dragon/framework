<?php

namespace Dragon\Database\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
	public $timestamps = false;
	
	protected $table = "users";
	protected $primaryKey = 'ID';
	
	protected $casts = [
		'user_registered'	=> 'datetime',
		'user_status'		=> 'int',
	];
}
