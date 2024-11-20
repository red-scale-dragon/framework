<?php

namespace Dragon\Posts;

use Dragon\Core\Util;
use Illuminate\Support\Pluralizer;

abstract class PostType {
	protected static string $tag = "";
	protected static string $name = "";
	protected static array $options = [];
	protected static array $messages = [];
	protected static array $bulkMessages = [];
	
	public static function init() {
		$plural = Pluralizer::plural(static::$name);
		register_post_type(
			static::$tag,
			array_merge_recursive([
				'labels'                => [
					'name'                  => $plural,
					'singular_name'         => static::$name,
					'all_items'             => 'All ' . $plural,
					'archives'              => static::$name . ' Archives',
					'attributes'            => static::$name . ' Attributes',
					'insert_into_item'      => 'Insert into ' . static::$name,
					'uploaded_to_this_item' => 'Uploaded to this ' . static::$name,
					'featured_image'        => 'Featured Image',
					'set_featured_image'    => 'Set featured image',
					'remove_featured_image' => 'Remove featured image',
					'use_featured_image'    => 'Use as featured image',
					'filter_items_list'     => 'Filter ' . static::$name . ' list',
					'items_list_navigation' => static::$name . ' list navigation',
					'items_list'            => $plural . ' lists',
					'new_item'              => 'New ' . static::$name,
					'add_new'               => 'Add New',
					'add_new_item'          => 'Add new ' . static::$name,
					'edit_item'             => 'Edit ' . static::$name,
					'view_item'             => 'View ' . static::$name,
					'view_items'            => 'View ' . $plural,
					'search_items'          => 'Search ' . $plural,
					'not_found'             => 'No ' . $plural . ' found',
					'not_found_in_trash'    => 'No ' . $plural . ' found in trash',
					'parent_item_colon'     => 'Parent ' . static::$name . ':',
					'menu_name'             => $plural,
				],
				'public'                => true,
				'hierarchical'          => false,
				'show_ui'               => true,
				'show_in_nav_menus'     => true,
				'supports'              => [ 'title', 'editor' ],
				'has_archive'           => true,
				'rewrite'               => true,
				'query_var'             => true,
				'menu_position'         => null,
				'menu_icon'             => 'dashicons-admin-post',
				'show_in_rest'          => true,
				'rest_base'             => static::$tag,
				'rest_controller_class' => 'WP_REST_Posts_Controller',
			], static::$options)
		);
	}
	
	public static function filterUpdatedMessages(array $messages) {
		global $post;
		
		$permalink = get_permalink($post);
		
		$revisionMessage = false;
		if (isset($_GET['revision'])) {
			$revisedTimestamp = wp_post_revision_title((int)$_GET['revision'], false);
			$revisionMessage = sprintf(static::$name . ' restored to revision from %s', $revisedTimestamp);
		}
		
		$messages[static::$tag] = array_merge([
			0  => '', // Unused. Messages start at index 1.
			1  => sprintf(static::$name . ' updated. <a target="_blank" href="%s">View ' . strtolower(static::$name) . '</a>', esc_url($permalink)),
			2  => 'Custom field updated.',
			3  => 'Custom field deleted.',
			4  => static::$name . ' updated.',
			5  => $revisionMessage,
			6  => sprintf(static::$name . ' published. <a href="%s">View ' . static::$name . '</a>', esc_url($permalink)),
			7  => static::$name . ' saved.',
			8  => sprintf(static::$name . ' submitted. <a target="_blank" href="%s">Preview ' . static::$name . '</a>', esc_url(add_query_arg('preview', 'true', $permalink))),
			9  => sprintf(static::$name . ' scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview ' . static::$name . '</a>', date_i18n( __( 'M j, Y @ G:i', 'YOUR-TEXTDOMAIN' ), strtotime($post->post_date)), esc_url($permalink)),
			10 => sprintf(static::$name . ' draft updated. <a target="_blank" href="%s">Preview ' . static::$name . '</a>', esc_url(add_query_arg('preview', 'true', $permalink))),
		], static::$messages);
		
		return $messages;
	}
	
	public static function filterBulkUpdatedMessages(array $bulkMessages, array $bulkCounts) {
		$plural = Pluralizer::plural(static::$name);
		
		$locked = '1 ' . static::$name . ' not updated, somebody is editing it.';
		if ($bulkCounts['locked'] > 1) {
			$locked = _n('%s ' . static::$name . ' not updated, somebody is editing it.', '%s ' . $plural .
					' not updated, somebody is editing them.', $bulkCounts['locked']);
		}
		
		$bulkMessages[static::$tag] = array_merge([
			'updated'   => _n('%s ' . static::$name . ' updated.', '%s ' . $plural . ' updated.', $bulkCounts['updated']),
			'locked'    => $locked,
			'deleted'   => _n('%s ' . static::$name . ' permanently deleted.', '%s ' . $plural . ' permanently deleted.', $bulkCounts['deleted']),
			'trashed'   => _n('%s ' . static::$name . ' moved to the Trash.', '%s ' . $plural . ' moved to the Trash.', $bulkCounts['trashed']),
			'untrashed' => _n('%s ' . static::$name . ' restored from the Trash.', '%s ' . $plural . ' restored from the Trash.', $bulkCounts['untrashed']),
		], static::$bulkMessages);
		
		return $bulkMessages;
	}
}
