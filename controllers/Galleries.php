<?php namespace Bedard\Photography\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Bedard\Photography\Models\Category;
use Bedard\Photography\Models\Gallery;
use Flash;
use Lang;
use October\Rain\Database\Builder;

/**
 * Galleries Back-end Controller.
 */
class Galleries extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Owl.Behaviors.ListDelete.Behavior',
    ];

    public $requiredPermissions = [
        'bedard.photography.galleries',
    ];

    public $formConfig = 'config_form.yaml';

    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bedard.Photography', 'photography', 'galleries');
    }

    /**
     * List index.
     *
     * @param  int|null     $userId
     * @return void
     */
    public function index($userId = null)
    {
        $this->loadCategories();
        $this->asExtension('ListController')->index();
    }

    /**
     * Join subqueries.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function listExtendQueryBefore(Builder $query)
    {
        $query->joinPhotoCount();
    }

    /**
     * Attach out select statements.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function listExtendQuery(Builder $query)
    {
        $query->select([
            'bedard_photography_galleries.*',
            'system_files.photo_count',
        ]);
    }

    /**
     * Load the categories.
     *
     * @return void
     */
    public function loadCategories()
    {
        $this->vars['categories'] = Category::orderBy('name')->get();
    }

    /**
     * Add galleries to a category via the toolbar.
     */
    public function onAddToCategory()
    {
        $categoryId = post('category_id');
        $galleryIds = post('checked');

        if ($categoryId && $galleryIds && is_array($galleryIds) && count($galleryIds)) {
            $galleries = Gallery::find($galleryIds);
            foreach ($galleries as $gallery) {
                $gallery->categories()->attach($categoryId);
            }

            Flash::success(Lang::get('bedard.photography::lang.galleries.list.attached_to_category'));
        }

        return $this->listRefresh();
    }

    /**
     * Toggle the "is_featured" flag for one or more categories
     */
    public function onFeature()
    {
        $isFeatured = (boolean) post('is_featured');
        $galleryIds = post('checked');

        if ($galleryIds && is_array($galleryIds) && count($galleryIds)) {
            $galleries = Gallery::find($galleryIds);
            foreach ($galleries as $gallery) {
                $gallery->is_featured = $isFeatured;
                $gallery->save();
            }

            $message = $isFeatured
                ? 'bedard.photography::lang.galleries.list.feature_add_success'
                : 'bedard.photography::lang.galleries.list.feature_remove_success';

            Flash::success(Lang::get($message));
        }

        return $this->listRefresh();
    }
}
