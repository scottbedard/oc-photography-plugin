<?php namespace Bedard\Photography\Factories;

use Bedard\Photography\Models\Gallery;
use Bedard\Photography\Factories\BaseFactory;

class GalleryFactory extends BaseFactory
{
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
