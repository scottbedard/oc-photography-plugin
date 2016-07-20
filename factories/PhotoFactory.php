<?php namespace Bedard\Photography\Factories;

use Bedard\Photography\Models\Photo;
use System\Models\File;

class PhotoFactory extends BaseFactory
{
    /**
     * Get the default model values.
     *
     * @return array
     */
    public function getDefaults()
    {
        return [];
    }

    /**
     * Get a new instance of the model being created.
     *
     * @return object
     */
    public function getModel()
    {
        $photo = new Photo;
        $photo->fromFile(plugins_path('bedard/photography/assets/images/dev_photo.jpg'));
        return $photo;
    }
}
