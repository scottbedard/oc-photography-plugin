<?php namespace Bedard\Photography\Repositories;

use Bedard\Photography\Models\Category;

class CategoryRepository
{
    /**
     * Fetch a single category and a page of galleries.
     *
     * @param  string                               $slug
     * @param  array                                $options
     * @return \October\Rain\Database\Collection
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function find($slug, array $options = [])
    {
        $category = Category::whereSlug($slug)
            ->with([
                'galleries' => function($q) use ($options) {
                    // @tood: apply pagination query constraints, and eager load thumbnails
                    return $q;
                },
            ])
            ->firstOrFail();

        return $category;
    }
}
