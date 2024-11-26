<?php

namespace Dragon\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CommentMeta extends Model {
	public $timestamps = false;
	
	protected $table = "commentmeta";
	protected $primaryKey = 'meta_id';
	
	public function comment() : HasOne {
		return $this->hasOne(Comment::class);
	}
}
