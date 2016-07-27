<?php namespace Bedard\Photography\Factories;

use Bedard\Photography\Models\Category;

class CategoryFactory extends BaseFactory
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
        ];
    }

    /**
     * Get a new instance of the model being created.
     *
     * @return object
     */
    public function getModel()
    {
        return new Category;
    }
}
