<?php namespace Bedard\Photography\Factories;

use Bedard\Photography\Classes\BaseFactory;
use Bedard\Photography\Models\Watermark;
use System\Models\File;

class WatermarkFactory extends BaseFactory
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
        ];
    }

    /**
     * Get a new instance of the model being created.
     *
     * @return object
     */
    public function getModel()
    {
        $watermark = new Watermark;

        $watermark->bindEvent('model.afterCreate', function () use ($watermark) {
            $image = new File;
            $image->fromFile(plugins_path('bedard/photography/assets/images/dev_watermark.png'));
            $watermark->image = $image;
            $watermark->forceSave();
        });

        return $watermark;
    }
}
