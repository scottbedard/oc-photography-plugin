<?php namespace Bedard\Photography\Repositories;

use Bedard\Photography\Models\Gallery;

class GalleryRepository {


    public function get()
    {
        return Gallery::joinPhotoCount()
            ->select('*')
            ->get();
    }
}
