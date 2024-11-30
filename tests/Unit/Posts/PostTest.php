<?php

namespace Dragon\Tests\Unit\Posts;

use Tests\TestCase;
use Dragon\Posts\Post;

class PostTest extends TestCase {
	public function testCanGetContent() {
		$id = wp_insert_post(['post_content'=>'Some Post']);
		$content = Post::getContent($id);
		
		$this->assertSame('Some Post', $content);
	}
	
	public function testCanSetMeta() {
		$id = wp_insert_post(['post_content'=>'Some Post']);
		$this->assertSame('missing', Post::getPostMeta($id, "test_key", "missing"));
		
		Post::setPostMeta($id, "test_key", "my data");
		$this->assertSame('my data', Post::getPostMeta($id, "test_key", "missing"));
	}
}
