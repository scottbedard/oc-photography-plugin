<?php namespace Bedard\Photography\Models;

use Model;

/**
 * Watermark Model.
 */
class Watermark extends Model
{
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
     * @var array Relations
     */
    public $attachOne = [
        'image' => 'System\Models\File',
    ];

    public $hasMany = [
        'galleries' => 'Bedard\Photography\Models\Gallery',
    ];
}
