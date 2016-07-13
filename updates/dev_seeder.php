<?php namespace Bedard\Photography\Updates;

use Bedard\Photography\Models\Gallery;
use Carbon\Carbon;
use Faker;
use October\Rain\Database\Updates\Seeder;

class DevSeeder extends Seeder
{
    public function run()
    {
        if (app()->env !== 'dev') return;
        $this->seedGalleries(5);
    }

    protected function seedGalleries($quantity)
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < $quantity; $i++) {
            Gallery::create([
                'title' => $faker->words(4, true),
                'slug' => $faker->slug,
            ]);
        }
    }
}


