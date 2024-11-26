<?php

namespace Dragon\Support;

class Image {
    public static function getMediaImageUrlById(int $id, $size = "thumbnail") : ?string {
        if (is_array($size) && count($size) === 1) {
            $fullImageData = wp_get_attachment_image_src($id, 'full');
            $aspectMultiplier = $size[0] / $fullImageData[1];
            $height = $aspectMultiplier * $fullImageData[2];
            $size = [$size[0], $height];
        }
        
        $imageData = wp_get_attachment_image_src($id, $size);
        return empty($imageData) ? null : $imageData[0];
    }
    
    public static function getPathForMediaImageById(int $id) : ?string {
        $path = wp_get_original_image_path($id);
        return $path === false ? null : $path;
    }
}
