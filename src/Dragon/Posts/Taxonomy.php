<?php

namespace Dragon\Posts;

use Illuminate\Support\Pluralizer;

abstract class Taxonomy {
	protected static string $tag = "";
	protected static string $name = "";
	protected static array $options = [];
	protected static array $messages = [];
	
	public static function init() {
		$plural = Pluralizer::plural(static::$name);
		register_taxonomy(static::$tag, ['post'], array_merge_recursive([
			'hierarchical'          => false,
			'public'                => true,
			'show_in_nav_menus'     => true,
			'show_ui'               => true,
			'show_admin_column'     => false,
			'query_var'             => true,
			'rewrite'               => true,
			'capabilities'          => [
				'manage_terms' => 'edit_posts',
				'edit_terms'   => 'edit_posts',
				'delete_terms' => 'edit_posts',
				'assign_terms' => 'edit_posts',
			],
			'labels'                => [
				'name'                       => $plural,
				'singular_name'              => static::$name,
				'search_items'               => 'Search ' . $plural,
				'popular_items'              => 'Popular ' . $plural,
				'all_items'                  => 'All ' . $plural,
				'parent_item'                => 'Parent ' . static::$name,
				'parent_item_colon'          => 'Parent ' . static::$name . ':',
				'edit_item'                  => 'Edit ' . static::$name,
				'update_item'                => 'Update ' . static::$name,
				'view_item'                  => 'View ' . static::$name,
				'add_new_item'               => 'Add New ' . static::$name,
				'new_item_name'              => 'New ' . static::$name,
				'separate_items_with_commas' => 'Separate ' . strtolower($plural) . ' with commas',
				'add_or_remove_items'        => 'Add or remove ' . strtolower($plural),
				'choose_from_most_used'      => 'Choose from the most used ' . strtolower($plural),
				'not_found'                  => 'No ' . strtolower($plural) . ' found.',
				'no_terms'                   => 'No ' . strtolower($plural),
				'menu_name'                  => $plural,
				'items_list_navigation'      => $plural . ' list navigation',
				'items_list'                 => $plural . ' list',
				'most_used'                  => 'Most Used',
				'back_to_items'              => '&larr; Back to ' . strtolower($plural),
			],
			'show_in_rest'          => true,
			'rest_base'             => static::$tag,
			'rest_controller_class' => 'WP_REST_Terms_Controller',
		], static::$options));
	}
	
	public static function updatedMessages(array $messages) : array {
		$messages[static::$tag] = array_merge([
			0 => '', // Unused. Messages start at index 1.
			1 => static::$name . ' added.',
			2 => static::$name . ' deleted.',
			3 => static::$name . ' updated.',
			4 => static::$name . ' not added.',
			5 => static::$name . ' updated.',
			6 => static::$name . ' deleted.',
		], static::$messages);
		
		return $messages;
	}
}
