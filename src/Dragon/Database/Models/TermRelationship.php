<?php

namespace Dragon\Database\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TermRelationship extends Pivot {
	public $timestamps = false;
	
	protected $table = "term_relationships";
	
	protected $casts = [
		'object_id'			=> 'int', // Post ID
		'term_taxonomy_id'	=> 'int',
		'term_order'		=> 'int',
	];
}
