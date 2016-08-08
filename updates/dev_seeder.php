<?php namespace Bedard\Photography\Updates;

use Bedard\Photography\Factories\CategoryFactory;
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

        $this->seedCategories(5);
        $this->seedWatermarks(3);
        $this->seedGalleries(10, 3);
        $this->seedRates();
    }

    protected function seedCategories($quantity) {
        $factory = new CategoryFactory;
        $factory->seed($quantity);
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

    protected function seedRates()
    {
        $factory = new RateFactory;
        $factory->create(['name' => '1 to 5', 'photos' => 1, 'price_per_photo' => 10]);
        $factory->create(['name' => '6 to 10', 'photos' => 6, 'price_per_photo' => 8]);
        $factory->create(['name' => '11 to 15', 'photos' => 11, 'price_per_photo' => 6]);
        $factory->create(['name' => '16+', 'photos' => 16, 'price_per_photo' => 5]);
    }
}


