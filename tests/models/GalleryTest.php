<?php namespace Bedard\Contact\Tests;

use Bedard\Photography\Factories\GalleryFactory;
use Bedard\Photography\Models\Gallery;
use PluginTestCase;

class GalleryTest extends PluginTestCase
{
    public $factory;

    public function __construct()
    {
        $this->factory = new GalleryFactory;
    }

    //
    // Tests
    //
    public function test_joining_photo_count()
    {
        $gallery = $this->factory->create();
        $this->factory->attachPhoto($gallery);

        $query = Gallery::joinPhotoCount()->find($gallery->id);
        $this->assertEquals($query->photo_count, 1);
    }

    public function test_description_markdown_is_parsed_before_save()
    {
        $gallery = $this->factory->create(['description' => '*Foo*']);
        $this->assertEquals('<p><em>Foo</em></p>', $gallery->description_html);
    }

    public function test_checking_if_a_gallery_is_password_protected()
    {
        $foo = $this->factory->make();
        $bar = $this->factory->make(['password' => 'whatever']);
        $this->assertFalse($foo->isPasswordProtected());
        $this->assertTrue($bar->isPasswordProtected());
    }
}
