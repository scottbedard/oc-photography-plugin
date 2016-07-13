<?php namespace Bedard\Photography\Updates;

use System\Models\File;
use October\Rain\Database\Updates\Seeder;

use Bedard\Photography\Updates\Seeders\GallerySeeder;

class DevSeeder extends Seeder
{
    public function run()
    {
        if (app()->env !== 'dev') return;
        $this->seedGalleries(10, 5);
    }

    protected function seedGalleries($galleries, $photos)
    {
        File::whereAttachmentType('Bedard\Photography\Models\Gallery')->delete();
        $seeder = new GallerySeeder($photos);
        $seeder->run($galleries);
    }
}


