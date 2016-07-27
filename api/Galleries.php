<?php namespace Bedard\Photography\Api;

use Bedard\Photography\Repositories\GalleryRepository;
use Illuminate\Routing\Controller;

class Galleries extends Controller
{
    /**
     * Fetch a page of galleries.
     *
     * @param  \Bedard\Photography\Repositories\GalleryRepository   $repository
     * @return \October\Rain\Database\Collection
     */
    public function index(GalleryRepository $repository)
    {
        $options = input();

        return $repository->getPage($options);
    }

    /**
     * Fetch a single gallery, and optionally it's watermarked photos.
     *
     * @param  \Bedard\Photography\Repositories\GalleryRepository   $repository
     * @param  string                                               $slug
     * @return \October\Rain\Database\Collection
     */
    public function show(GalleryRepository $repository, $slug)
    {
        $options = input();

        return $repository->find($slug, $options);
    }
}
