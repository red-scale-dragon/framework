<?php

namespace Dragon\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Link extends Model {
	public $timestamps = false;
	
	protected $table = "links";
	protected $primaryKey = 'link_id';
	
	protected $casts = [
		'link_owner'	=> 'int',
		'link_rating'	=> 'int',
		'link_updated'	=> 'datetime',
	];
	
	public function owner() : HasOne {
		return $this->hasOne(User::class);
	}
}
