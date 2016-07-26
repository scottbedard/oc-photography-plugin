<?php namespace Bedard\Photography\Repositories;

use Bedard\Photography\Models\Gallery;

class GalleryRepository
{
    /**
     * Fetch a single gallery and a page of photos
     *
     * @param  string                               $slug
     * @param  array                                $options
     * @return \October\Rain\Database\Collection
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function find($slug, array $options = [])
    {
        $query = Gallery::query();

        // @todo: Create an ApiSettings model to define these defaults
        if (! array_key_exists('joinPhotoCount', $options)) {
            $options['joinPhotoCount'] = true;
        }

        if (boolval($options['joinPhotoCount'])) {
            $query->joinPhotoCount()->select([
                'bedard_photography_galleries.*',
                'system_files.photo_count',
            ]);
        }

        $gallery = $query
            ->with('rates')
            ->whereSlug($slug)
            ->firstOrFail();

        return $gallery;
    }

    /**
     * Fetch a page of galleries.
     *
     * @param  array    $options    Query options
     * @return \October\Rain\Database\Collection
     */
    public function getPage(array $options = [])
    {
        // @todo: Create an ApiSettings model to define these defaults
        if (! array_key_exists('joinPhotoCount', $options)) {
            $options['joinPhotoCount'] = true;
        }
        if (! array_key_exists('order', $options)) {
            $options['order'] = 'desc';
        }
        if (! array_key_exists('orderBy', $options)) {
            $options['orderBy'] = 'created_at';
        }
        if (! array_key_exists('page', $options)) {
            $options['page'] = 1;
        }
        if (! array_key_exists('pageSize', $options)) {
            $options['pageSize'] = 10;
        }

        // Start building the query with the photo count if neccessary
        $query = Gallery::query();
        if (boolval($options['joinPhotoCount'])) {
            $query->joinPhotoCount()->select([
                'bedard_photography_galleries.*',
                'system_files.photo_count',
            ]);
        }

        // Build the rest of the query and execute it
        return $query
            ->orderBy($options['orderBy'], $options['order'])
            ->skip(($options['page'] - 1) * $options['pageSize'])
            ->take($options['pageSize'])
            ->get();
    }
}
