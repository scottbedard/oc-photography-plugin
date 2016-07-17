<?php namespace Bedard\Photography\Updates;

use System\Models\File;
use October\Rain\Database\Updates\Seeder;
use Bedard\Photography\Updates\Seeders\GallerySeeder;
use Bedard\Photography\Updates\Seeders\WatermarkSeeder;

class DevSeeder extends Seeder
{
    public function run()
    {
        if (app()->env !== 'dev') return;
        $this->seedWatermarks(3);
        $this->seedGalleries(10, 5);
    }

    protected function seedWatermarks($watermarks) {
        $seeder = new WatermarkSeeder;
        $seeder->run($watermarks);
    }

    protected function seedGalleries($galleries, $photos)
    {
        File::whereAttachmentType('Bedard\Photography\Models\Gallery')->delete();
        $seeder = new GallerySeeder($photos);
        $seeder->run($galleries);
    }
}


