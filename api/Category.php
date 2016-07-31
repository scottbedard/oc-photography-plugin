<?php namespace Bedard\Photography\Api;

use Bedard\Photography\Repositories\CategoryRepository;
use Exception;
use Illuminate\Routing\Controller;

class Category extends Controller
{
    /**
     * Fetch a single category, and a page of it's galleries.
     *
     * @param  \Bedard\Photography\Repositories\CategoryRepository  $repository
     * @param  string                                               $slug
     * @return \October\Rain\Database\Collection
     */
    public function show(CategoryRepository $repository, $slug)
    {
        try {
            $options = input();
            $response = $repository->find($slug, $options);
        } catch (Exception $e) {
            abort(500, $e->getMessage());
        }

        return $response;
    }
}
