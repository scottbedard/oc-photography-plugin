<?php namespace Bedard\Photography\Api;

use Bedard\Photography\Models\Gallery;
use Bedard\Photography\Repositories\GalleryRepository;
use Illuminate\Routing\Controller;

class Galleries extends Controller
{

    /**
     * Fetch galleries
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(GalleryRepository $repository)
    {
        return $repository->get();
    }
}
