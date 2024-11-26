<?php

namespace Dragon\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Comment extends Model {
	public $timestamps = false;
	
	protected $table = "comments";
	protected $primaryKey = 'comment_ID';
	
	protected $casts = [
		'comment_post_ID'	=> 'int',
		'comment_date'		=> 'datetime',
		'comment_date_gmt'	=> 'datetime',
		'comment_karma'		=> 'int',
		'comment_parent'	=> 'int',
		'user_id'			=> 'int',
	];
	
	public function parent() : HasOne {
		return $this->hasOne(Comment::class);
	}
	
	public function user() : HasOne {
		return $this->hasOne(User::class);
	}
	
	public function post() : HasOne {
		return $this->hasOne(Post::class);
	}
}
