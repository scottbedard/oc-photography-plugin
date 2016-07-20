<?php namespace Bedard\Contact\Tests;

use Bedard\Photography\Factories\PhotoFactory;
use Bedard\Photography\Factories\GalleryFactory;
use Bedard\Photography\Factories\WatermarkFactory;
use Bedard\Photography\Models\Gallery;
use PluginTestCase;
use System\Models\File;

class PhotoTest extends PluginTestCase
{
    public $factory;

    public function __construct()
    {
        $this->factory = new PhotoFactory;
        $this->galleryFactory = new GalleryFactory;
        $this->watermarkFactory = new WatermarkFactory;
    }

    public function test_that_a_watermarked_copy_is_created()
    {
        $this->galleryFactory->seed(1)->attachPhotos(1);
        $this->assertEquals(1, File::count());
        $gallery = Gallery::get()->first();
        $watermark = $this->watermarkFactory->forceCreate();
        $gallery->watermark = $watermark;
        $gallery->save();
        $photo = $gallery->photos()->get()->first();
        $photo->syncWatermarks();
        $this->assertEquals(2, File::count());
    }
}
