<?php

namespace Dragon\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model {
	public $timestamps = false;
	
	protected $table = "options";
	protected $primaryKey = 'option_id';
}
