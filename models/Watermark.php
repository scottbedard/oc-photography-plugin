<?php namespace Bedard\Photography\Models;

use Model;

/**
 * Watermark Model.
 */
class Watermark extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bedard_photography_watermarks';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required',
        'image' => 'required',
    ];

    /**
     * @var array Relations
     */
    public $attachOne = [
        'image' => 'System\Models\File',
    ];

    public $hasMany = [
        'galleries' => 'Bedard\Photography\Models\Gallery',
    ];
}
