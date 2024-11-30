<?php

namespace Dragon\Posts;

class Post {
    public static function getContent($postId) : string {
        $post = get_post($postId);
        return $post->post_content;
    }
    
    public static function setPostMeta(int $postId, string $key, $value) {
        update_post_meta($postId, $key, $value);
    }
    
    public static function getPostMeta(int $postId, string $key, $default = null) {
        $data = get_post_meta($postId, $key, true);
        return empty($data) ? $default : $data;
    }
}
