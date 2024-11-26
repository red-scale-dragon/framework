<?php

namespace Dragon\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model {
	public $timestamps = false;
	
	protected $table = "posts";
	protected $primaryKey = 'ID';
	
	protected $casts = [
		'post_author'		=> 'int',
		'post_date'			=> 'datetime',
		'post_date_gmt'		=> 'datetime',
		'post_modified'		=> 'datetime',
		'post_modified_gmt'	=> 'datetime',
		'post_parent'		=> 'int',
		'menu_order'		=> 'int',
		'comment_count'		=> 'int',
	];
	
	public function author() : HasOne {
		return $this->hasOne(User::class);
	}
	
	public function parent() : HasOne {
		return $this->hasOne(Post::class);
	}
	
	public function taxonomies() : BelongsToMany {
		return $this->belongsToMany(TermTaxonomy::class, null, 'object_id', 'term_taxonomy_id')
		->using(TermRelationship::class);
	}
}
