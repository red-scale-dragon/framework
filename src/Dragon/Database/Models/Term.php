<?php

namespace Dragon\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model {
	public $timestamps = false;
	
	protected $table = "terms";
	protected $primaryKey = 'term_id';
	
	protected $casts = [
		'term_group'	=> 'int',
	];
}
