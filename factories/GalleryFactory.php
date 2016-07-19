<?php namespace Bedard\Photography\Factories;

use Bedard\Photography\Models\Gallery;
use System\Models\File;

class GalleryFactory extends BaseFactory
{
    /**
     * Attach a single photo to a gallery.
     *
     * @param  \Bedard\Photography\Models\Gallery   $gallery
     * @return void
     */
    public function attachPhoto(Gallery $gallery)
    {
        $photo = new File;
        $photo->fromFile(plugins_path('bedard/photography/assets/images/dev_photo.jpg'));
        $gallery->photos()->add($photo);
    }

    /**
     * Attach some photos to the seeded galleries.
     *
     * @param  int  $quantity
     * @return void
     */
    public function attachPhotos($quantity)
    {
        foreach ($this->collection as $gallery) {
            for ($i = 0; $i < $quantity; $i++) {
                $this->attachPhoto($gallery);
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
