<?php

namespace Dragon\Tests\Unit\Posts;

use Tests\TestCase;
use Dragon\Posts\PostType;

class PostTypeStub extends PostType {
	protected static string $tag = "test-type";
	protected static string $name = "Test Type";
}

class PostTypeTest extends TestCase {
	public function testCanCreateCustomPostType() {
		$this->assertFalse(post_type_exists('test-type'));
		PostTypeStub::init();
		$this->assertTrue(post_type_exists('test-type'));
	}
	
	public function testCanGetMessagesForPostType() {
		global $post;
		$post = \WP_Post::get_instance(wp_insert_post(['post_content'=>'Some Post']));
		
		$messages = PostTypeStub::filterUpdatedMessages([]);
		$this->assertNotEmpty($messages);
	}
	
	public function testCanGetBulkMessagesForPostType() {
		$messages = PostTypeStub::filterBulkUpdatedMessages([], [
			'locked' => 1,
			'updated' => 1,
			'deleted' => 1,
			'trashed' => 1,
			'untrashed' => 1,
		]);
		$this->assertNotEmpty($messages);
	}
}
