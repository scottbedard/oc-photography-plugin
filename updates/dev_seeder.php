<?php namespace Bedard\Photography\Updates;

use System\Models\File;
use October\Rain\Database\Updates\Seeder;
use Bedard\Photography\Updates\Seeders\GallerySeeder;
use Bedard\Photography\Updates\Seeders\WatermarkSeeder;

use Bedard\Photography\Factories\GalleryFactory;

class DevSeeder extends Seeder
{
    public function run()
    {
        if (app()->env !== 'dev') return;

        // @todo: Seed images with watermarks
        // $this->seedWatermarks(3);

        $this->seedGalleries(10);
    }

    protected function seedWatermarks($watermarks) {
        $seeder = new WatermarkSeeder;
        $seeder->run($watermarks);
    }

    protected function seedGalleries($quantity)
    {
        File::whereAttachmentType('Bedard\Photography\Models\Gallery')->delete();
        $factory = new GalleryFactory;
        $factory->seed($quantity);
    }
}


