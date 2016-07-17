<?php namespace Bedard\Photography\Updates\Seeders;

use Bedard\Photography\Models\Watermark;
use Faker;

class WatermarkSeeder
{

    /**
     * Get the options for a seed
     *
     * @return array
     */
    public function getOptions()
    {
        $faker = Faker\Factory::create();

        return [
            'name' => $faker->words(3, true),
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
        $watermark = Watermark::create($options);
    }
}
