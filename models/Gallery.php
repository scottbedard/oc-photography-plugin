<?php namespace Bedard\Photography\Models;

use Model;

/**
 * Gallery Model
 */
class Gallery extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bedard_photography_galleries';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'title',
        'slug',
        'photo_price',
        'published_at',
    ];

    /**
     * @var array Date fields
     */
    protected $dates = [
        'published_at',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array Relations
     */
    public $attachMany = [
        'photos' => 'System\Models\File'
    ];
}
