<?php namespace Bedard\Contact\Tests;

use Bedard\Photography\Models\Gallery;
use Carbon\Carbon;
use Exception;
use Faker;
use PluginTestCase;

class GalleryTest extends PluginTestCase
{

    //
    // Factory methods
    //
    protected function makeGallery(array $options = [])
    {
        $faker = Faker\Factory::create();

        return Gallery::make([
            'name' => $faker->words(5, true),
            'slug' => $faker->slug,
            'published_at' => Carbon::now(),
            'description' => 'Foo *bar* baz',
        ])->fill($options);
    }

    protected function createGallery(array $options = [])
    {
        $gallery = $this->makeGallery($options);
        $gallery->save();
        return $gallery;
    }

    //
    // Tests
    //
    public function test_description_markdown_is_parsed_before_save()
    {
        $gallery = $this->createGallery(['description' => '*Foo*']);
        $this->assertEquals('<p><em>Foo</em></p>', $gallery->description_html);
    }
}
