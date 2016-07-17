<?php namespace Bedard\Photography\Updates\Seeders;

use Bedard\Photography\Models\Gallery;
use Carbon\Carbon;
use Faker;
use System\Models\File;

class GallerySeeder
{

    protected $placeholderPath = null;

    /**
     * Construct
     *
     * @param  int  $photos     The number of photos per gallery
     */
    public function __construct($photos = 0)
    {
        $this->placeholderPath = plugins_path('bedard/photography/assets/images/dev_photo.jpg');
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
        $photo = new File;
        $photo->fromFile($this->placeholderPath);
        $gallery->photos()->add($photo);
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
            'description' => 'An **awesome** photo gallery',
        ];
    }

    /**
     * Run
     *
     * @param  int  $quantity   The number of times to run the seeder
     * @return void
     */
    public function run($quantity, $photos)
    {
        for ($i = 0; $i < $quantity; $i++) {
            $this->seed($photos);
        }
    }

    /**
     * Seed
     *
     * @return void
     */
    public function seed($photos = 0)
    {
        $options = $this->getOptions();
        $gallery = Gallery::create($options);

        for ($i = 0; $i < $photos; $i++) {
            $this->attachPhoto($gallery);
        }
    }
}
