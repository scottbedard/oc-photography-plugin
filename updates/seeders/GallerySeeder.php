<?php namespace Bedard\Photography\Updates\Seeders;

use Bedard\Photography\Models\Gallery;
use Carbon\Carbon;
use Faker;
use System\Models\File;

class GallerySeeder
{

    /**
     * Construct
     *
     * @param  int  $photos     The number of photos per gallery
     */
    public function __construct($photos = 1)
    {
        $this->photos = $photos;
    }

    /**
     * Attach photos to a gallery
     *
     * @param  \Bedard\Photography\Models\Gallery   $gallery
     * @param  int                                  $quantity
     * @return void
     */
    public function attachPhoto(Gallery $gallery)
    {
        $gallery->photos()->create([]);
    }

    /**
     * Get the options for a seed
     *
     * @return array
     */
    public function getOptions()
    {
        $faker = Faker\Factory::create();

        return [
            'name' => $faker->words(5, true),
            'slug' => $faker->slug,
        ];
    }

    /**
     * Run
     *
     * @param  int  $quantity   The number of times to run the seeder
     * @return void
     */
    public function run($quantity)
    {
        for ($i = 0; $i < $quantity; $i++) {
            $this->seed();
        }
    }

    /**
     * Seed
     *
     * @return void
     */
    public function seed()
    {
        $options = $this->getOptions();
        $gallery = Gallery::create($options);

        for ($i = 0; $i < $this->photos; $i++) {
            $this->attachPhoto($gallery);
        }
    }
}
