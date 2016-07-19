<?php namespace Bedard\Photography\Classes;

use Bedard\Photography\Models\Photo;
use Bedard\Photography\Models\Watermark;
use Image;
use Symfony\Component\Filesystem\Filesystem;
use System\Models\File;

class ImageEditor
{

    /**
     * Create a watermarked version of a photo
     *
     * @param  \Bedard\Photography\Models\Photo
     * @return \System\Models\File
     */
    public static function createWatermarkedFile(Photo $photo)
    {
        // Create a temporary file with the watermark
        $tempPath = temp_path("watermark_{$photo->getFileName()}");
        $image = Image::make($photo->getLocalPath());
        $image->save($tempPath);

        // Convert that temporary file to a system file and clean up our mess
        $file = File::make()->fromFile($tempPath);
        $fs = new Filesystem;
        $fs->remove($tempPath);

        return $file;
    }
}
