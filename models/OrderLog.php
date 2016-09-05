<?php namespace Bedard\Photography\Models;

use Model;

/**
 * OrderLog Model
 */
class OrderLog extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bedard_photography_order_logs';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'status',
    ];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'order' => [
            'Bedard\Photography\Models\Order',
        ],
    ];

}
