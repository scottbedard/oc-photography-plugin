<?php namespace Bedard\Photography\Factories;

use Bedard\Photography\Classes\BaseFactory;
use Bedard\Photography\Models\Gallery;
use System\Models\File;

class GalleryFactory extends BaseFactory
{
    /**
     * Attach some photos to the seeded galleries.
     *
     * @param  int  $quantity
     * @return void
     */
    public function attachPhotos($quantity)
    {
        $photoPath = plugins_path('bedard/photography/assets/images/dev_photo.jpg');
        foreach ($this->collection as $gallery) {
            for ($i = 0; $i < $quantity; $i++) {
                $photo = new File;
                $photo->fromFile($photoPath);
                $gallery->photos()->add($photo);
            }
        }
    }

    /**
     * Get the default model values.
     *
     * @return array
     */
    public function getDefaults()
    {
        return [
            'name' => $this->faker->words(3, true),
            'slug' => $this->faker->slug,
            'description' => 'An **awesome** photo gallery',
            'photo_price' => 0,
        ];
    }

    /**
     * Get a new instance of the model being created.
     *
     * @return object
     */
    public function getModel()
    {
        return new Gallery;
    }
}
