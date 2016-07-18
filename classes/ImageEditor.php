<?php namespace Bedard\Photography\Classes;

use Bedard\Photography\Models\Gallery;
use Bedard\Photography\Models\Watermark;
use Image;
use System\Models\File;

class ImageEditor
{
    /**
     * Apply a watermark to a photo.
     *
     * @param  \Bedard\Photography\Models\Gallery       $gallery
     * @param  \Bedard\Photography\Models\Watermark     $watermark
     * @param  \System\Models\File                      $photo
     * @return stdObject
     */
    public static function watermark(Gallery $gallery, Watermark $watermark, File $photo)
    {
        // First create a temporary file
        $photoPath = $photo->getLocalPath();
        $watermarkPath = $watermark->image->getLocalPath();
        $outputPath = temp_path("watermark_{$photo->id}_{$photo->getFileName()}");
        $image = Image::make($photoPath)->insert($watermarkPath);
        $image->save($outputPath);

        return $outputPath;
    }
}
