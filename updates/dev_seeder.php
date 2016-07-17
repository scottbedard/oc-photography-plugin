<?php namespace Bedard\Photography\Updates;

use Bedard\Photography\Factories\GalleryFactory;
use System\Models\File;
use October\Rain\Database\Updates\Seeder;
use Bedard\Photography\Updates\Seeders\WatermarkSeeder;

class DevSeeder extends Seeder
{
    public function run()
    {
        if (app()->env !== 'dev') return;

        // @todo: Seed images with watermarks
        // $this->seedWatermarks(3);

        $this->seedGalleries(10, 3);
    }

    protected function seedWatermarks($watermarks) {
        $seeder = new WatermarkSeeder;
        $seeder->run($watermarks);
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
}


