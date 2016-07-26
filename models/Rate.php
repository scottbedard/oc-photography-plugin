<?php namespace Bedard\Photography\Models;

use Model;

/**
 * Rate Model
 */
class Rate extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bedard_photography_rates';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'galleries' => [
            'Bedard\Photography\Models\Gallery',
            'table' => 'bedard_photography_gallery_rate',
        ],
    ];

}
