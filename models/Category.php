<?php namespace Bedard\Photography\Models;

use Model;

/**
 * Category Model.
 */
class Category extends Model
{
    use \Bedard\Photography\Traits\Subqueryable,
        \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bedard_photography_categories';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required',
        'slug' => 'required|unique:bedard_photography_categories',
    ];

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'galleries' => [
            'Bedard\Photography\Models\Gallery',
            'table' => 'bedard_photography_category_gallery',
        ],
    ];
}
