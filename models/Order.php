<?php namespace Bedard\Photography\Models;

use Bedard\Photography\Models\Gallery;
use Model;

/**
 * Order Model
 */
class Order extends Model
{
    use \October\Rain\Database\Traits\Encryptable,
        \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bedard_photography_orders';

    protected $casts = [
        'amount' => 'float',
    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Encryptable attributes
     */
    protected $encryptable = [
        'stripe_token',
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'amount',
        'email',
        'name',
        'status',
        'session_token',
        'stripe_token',
    ];

    protected $hidden = [
        'session_token',
        'stripe_token',
    ];

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'photos' => [
            'Bedard\Photography\Models\Photo',
            'table' => 'bedard_photography_order_photo',
        ],
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'amount' => 'numeric|min:0',
        'email' => 'email',
    ];

    /**
     * Before create
     *
     * @return void
     */
    public function beforeCreate()
    {
        $this->session_token = str_random(40);
    }

    public function beforeSave()
    {
        $this->calculateAmount();
    }

    /**
     * Calculate the total for the order
     *
     * @return float
     */
    public function calculateAmount()
    {

        $photos = $this->photos()->get();
        $galleries = Gallery::whereHasPhotos($photos->lists('id'))->with('rates')->get();

        $amount = 0;
        $galleries->each(function($gallery) use (&$amount, $photos) {

            // Determine how many photos we have in this gallery
            $count = $photos->filter(function($photo) use ($gallery) {
                return $photo->attachment_id == $gallery->id;
            })->count();

            // Calculate which rate we fall into
            $rate = $gallery->rates->filter(function($rate) use ($count) {
                return $rate->photos <= $count;
            })->min('price_per_photo');

            // Increment the total amount
            $amount += $count * $rate;
        });

        $this->amount = $amount;
    }

    /**
     * Find an order by it's session token and ID
     *
     * @return Bedard\Photography\Models\Order
     */
    public function scopeFindBySession($query, $session)
    {
        return $query
            ->whereSessionToken($session['token'])
            ->find($session['id']);
    }
}
