<?php namespace Bedard\Photography\Classes;

use Bedard\Photography\Models\Watermark;
use Intervention\Image\ImageManager;
use System\Models\File;

class Image
{
    /**
     * Apply a watermark to a photo.
     *
     * @param  \System\Models\File                      $photo
     * @param  \Bedard\Photography\Models\Watermark     $watermark
     * @param  string                                   $text
     * @return \System\Models\File
     */
    public static function watermark(File $photo, Watermark $watermark, $text = null)
    {
        $image = ImageManager::make($photo->getPublicPath());
    }
}
