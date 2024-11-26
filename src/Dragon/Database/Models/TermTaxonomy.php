<?php

namespace Dragon\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TermTaxonomy extends Model {
	public $timestamps = false;
	
	protected $table = "term_taxonomy";
	protected $primaryKey = 'term_taxonomy_id';
	
	protected $casts = [
		'term_id'	=> 'int',
		'parent'	=> 'int',
		'count'		=> 'int',
	];
	
	public function term() : HasOne {
		return $this->hasOne(Term::class);
	}
	
	public function parent() : HasOne {
		return $this->hasOne(TermTaxonomy::class);
	}
	
	public function posts() : BelongsToMany {
		return $this->belongsToMany(Post::class, null, 'term_taxonomy_id', 'object_id')
		->using(TermRelationship::class);
	}
}
