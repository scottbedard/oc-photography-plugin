<?php namespace Bedard\Photography\Api;

use Bedard\Photography\Repositories\GalleryRepository;
use Illuminate\Routing\Controller;

class Galleries extends Controller
{

    /**
     * Fetch a page of galleries
     *
     * @param  \Bedard\Photography\Repositories\GalleryRepository   $repository
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(GalleryRepository $repository)
    {
        $options = input();
        return $repository->getPage($options);
    }
}
