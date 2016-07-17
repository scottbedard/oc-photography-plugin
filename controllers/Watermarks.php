<?php namespace Bedard\Photography\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Watermarks Back-end Controller.
 */
class Watermarks extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Owl.Behaviors.ListDelete.Behavior',
    ];

    public $requiredPermissions = [
        'bedard.photography.watermarks',
    ];

    public $formConfig = 'config_form.yaml';

    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bedard.Photography', 'photography', 'watermarks');
    }
}
