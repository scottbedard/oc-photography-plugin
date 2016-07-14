<?php namespace Bedard\Contact\Tests;

use Bedard\Photography\Repositories\GalleryRepository;
use PluginTestCase;

class GalleryRepositoryTest extends PluginTestCase
{

    //
    // Tests
    //
    public function test_it_returns_a_collection()
    {
        $repository = new GalleryRepository;
        $response = $repository->getPage();
        $this->assertEquals('Illuminate\Database\Eloquent\Collection', get_class($response));
    }
}
