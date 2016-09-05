<?php namespace Bedard\Photography\Models;

use Exception;
use Mail;
use Model;
use Stripe;
use Queue;

/**
 * Order Model.
 */
class Order extends Model
{
    use \October\Rain\Database\Traits\Encryptable,
        \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bedard_photography_orders';

    /**
     * @var array Default attributes
     */
    public $attributes = [
        'amount' => 0,
    ];

    /**
     * @var array Attribute casting
     */
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

    public $hasMany = [
        'logs' => [
            'Bedard\Photography\Models\OrderLog',
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
     * After created.
     *
     * @return void
     */
    public function afterCreate()
    {
        $this->logStatus('created');
    }

    /**
     * Before create.
     *
     * @return void
     */
    public function beforeCreate()
    {
        $this->session_token = str_random(40);
    }

    /**
     * Before save.
     *
     * @return void
     */
    public function beforeSave()
    {
        $this->calculateAmount();
    }

    /**
     * Calculate the total for the order.
     *
     * @return float
     */
    public function calculateAmount()
    {
        $photos = $this->photos()->get();
        $galleries = Gallery::whereHasPhotos($photos->lists('id'))->with('rates')->get();

        $amount = 0;
        $galleries->each(function ($gallery) use (&$amount, $photos) {

            // Determine how many photos we have in this gallery
            $count = $photos->filter(function ($photo) use ($gallery) {
                return $photo->attachment_id == $gallery->id;
            })->count();

            // Calculate which rate we fall into
            $rate = $gallery->rates->filter(function ($rate) use ($count) {
                return $rate->photos <= $count;
            })->min('price_per_photo');

            // Increment the total amount
            $amount += $count * $rate;
        });

        $this->amount = $amount;
    }

    /**
     * Charge the user.
     *
     * @return void
     */
    public function charge()
    {
        // Attempt to charge the user
        try {
            $this->incrementStripeAttempts();

            $customer = Stripe\Customer::create([
                'email' => $this->email,
                'source'  => $this->stripe_token,
            ]);

            $charge = Stripe\Charge::create([
                'amount'   => $this->amountInCents,
                'currency' => 'usd',
                'customer' => $customer->id,
            ]);

            $this->paymentComplete();
        }

        // If anything went wrong, mark the order as failed and re-queue it
        catch (Exception $e) {
            if ($this->stripe_attempts < Settings::getStripeAttempts()) {
                $this->queueStripePayment();
            } else {
                $this->paymentFailed($e->getMessage());
            }
        }
    }

    /**
     * Return the amount of the order in cents.
     *
     * @return int
     */
    public function getAmountInCentsAttribute()
    {
        return $this->amount * 100;
    }

    /**
     * Increment the number of payment attempts made.
     *
     * @return void
     */
    public function incrementStripeAttempts()
    {
        $this->stripe_attempts += 1;
        $this->save();
    }

    /**
     * Log the current status.
     *
     * @return void
     */
    public function logStatus($status = null)
    {
        if (is_null($status)) {
            $status = $this->status;
        } else {
            $this->status = $status;
            $this->save();
        }

        $this->logs()->create(['status' => $status]);
    }

    /**
     * Mark a payment as complete.
     *
     * @return void
     */
    public function paymentComplete()
    {
        // Create a unique download token
        do {
            $this->download_token = str_random(12);
        } while (self::whereDownloadToken($this->download_token)->exists());

        $this->logStatus('complete');

        // Send the success email
        Mail::send('bedard.photography::mail.complete', $this->attributes, function ($message) {
            $message->to($this->email, $this->name);
        });
    }

    /**
     * Mark a payment as failed.
     *
     * @return void
     */
    public function paymentFailed()
    {
        $this->logStatus('failed');

        // Send the failed email
        Mail::send('bedard.photography::mail.failed', $this->attributes, function ($message) {
            $message->to($this->email, $this->name);
        });
    }

    /**
     * Queue the stripe charge.
     *
     * @return void
     */
    public function queueStripePayment()
    {
        $id = $this->id;

        if ($this->stripe_attempts === 0) {
            $this->logStatus();
        }

        Queue::push(function ($job) use ($id) {
            $order = Order::findOrFail($id)->charge();
            $job->delete();
        });
    }

    /**
     * Find an order by it's session token and ID.
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
