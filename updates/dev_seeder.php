<?php namespace Bedard\Photography\Updates;

use Bedard\Photography\Factories\GalleryFactory;
use Bedard\Photography\Factories\RateFactory;
use Bedard\Photography\Factories\WatermarkFactory;
use System\Models\File;
use October\Rain\Database\Updates\Seeder;

class DevSeeder extends Seeder
{
    public function run()
    {
        if (app()->env !== 'dev') {
            return;
        }

        $this->seedWatermarks(3);
        $this->seedGalleries(10, 3);
        $this->seedRates(5);
    }

    protected function seedWatermarks($quantity) {
        $watermarks = File::whereAttachmentType('Bedard\Photography\Models\Watermark')->get();
        foreach ($watermarks as $watermark) {
            $watermark->delete();
        }

        $factory = new WatermarkFactory;
        $factory->forceSeed($quantity);
    }

    protected function seedGalleries($quantity, $photos)
    {
        $galleries = File::whereAttachmentType('Bedard\Photography\Models\Gallery')->get();
        foreach ($galleries as $gallery) {
            $gallery->delete();
        }

        $factory = new GalleryFactory;
        $factory->seed($quantity)->attachPhotos($photos);
    }

    protected function seedRates($quantity)
    {
        $factory = new RateFactory;
        $factory->seed($quantity);
    }
}


