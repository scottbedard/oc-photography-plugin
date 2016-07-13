<?php namespace Bedard\Photography\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use October\Rain\Database\Builder;

/**
 * Galleries Back-end Controller
 */
class Galleries extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bedard.Photography', 'photography', 'galleries');
    }

    /**
     * Join subqueries
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function listExtendQueryBefore(Builder $query)
    {
        $query->joinPhotoCount();
    }

    /**
     * Attach out select statements
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function listExtendQuery(Builder $query)
    {
        $query->select([
            'bedard_photography_galleries.*',
            'system_files.photos_count',
        ]);
    }
}
