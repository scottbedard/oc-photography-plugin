<?php namespace Bedard\Contact\Tests;

use Bedard\Photography\Models\Gallery;
use Carbon\Carbon;
use Faker;
use PluginTestCase;
use System\Models\File;

class GalleryTest extends PluginTestCase
{
    //
    // Factory methods
    //
    protected function createFile(array $options = [])
    {
        $file = $this->makeFile($options);
        $file->save();

        return $file;
    }

    protected function createGallery(array $options = [])
    {
        $gallery = $this->makeGallery($options);
        $gallery->save();

        return $gallery;
    }

    protected function makeFile(array $options = [])
    {
        $default = [
            'attachment_type' => 'Bedard\Photography\Models\Gallery',
            'content_type' => '',
            'disk_name' => '',
            'file_name' => '',
            'file_size' => 0,
        ];

        $file = new File;
        foreach ($default as $key => $value) {
            $file->$key = $value;
        }
        foreach ($options as $key => $value) {
            $file->$key = $value;
        }

        return $file;
    }

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

    //
    // Tests
    //
    public function test_joining_photo_count()
    {
        $gallery = $this->createGallery();
        $photo = $this->createFile(['attachment_id' => $gallery->id]);

        $query = Gallery::joinPhotoCount()->find($gallery->id);
        $this->assertEquals($query->photo_count, 1);
    }

    public function test_description_markdown_is_parsed_before_save()
    {
        $gallery = $this->createGallery(['description' => '*Foo*']);
        $this->assertEquals('<p><em>Foo</em></p>', $gallery->description_html);
    }
}
