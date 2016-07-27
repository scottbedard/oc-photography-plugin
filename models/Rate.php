<?php namespace Bedard\Photography\Models;

use Model;

/**
 * Rate Model.
 */
class Rate extends Model
{
    use \Bedard\Photography\Traits\Subqueryable,
        \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bedard_photography_rates';

    /**
     * @var array Attributes
     */
    public $attributes = [
        'photos' => 0,
        'price_per_photo' => 0,
    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'is_active',
        'name',
        'photos',
        'price_per_photo',
    ];

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'galleries' => [
            'Bedard\Photography\Models\Gallery',
            'table' => 'bedard_photography_gallery_rate',
        ],
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'is_active' => 'boolean',
        'name' => 'required|unique:bedard_photography_rates',
        'photos' => 'required|integer|min:0',
        'price_per_photo' => 'required|numeric|min:0',
    ];
}
