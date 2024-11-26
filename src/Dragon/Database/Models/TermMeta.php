<?php

namespace Dragon\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TermMeta extends Model {
	public $timestamps = false;
	
	protected $table = "termmeta";
	protected $primaryKey = 'meta_id';
	
	protected $casts = [
		'term_id'	=> 'int',
	];
	
	public function term() : HasOne {
		return $this->hasOne(Term::class);
	}
}
