<?php

namespace Dragon\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PostMeta extends Model {
	public $timestamps = false;
	
	protected $table = "postmeta";
	protected $primaryKey = 'meta_id';
	
	protected $casts = [
		'post_id'	=> 'int',
	];
	
	public function post() : HasOne {
		return $this->hasOne(Post::class);
	}
}
