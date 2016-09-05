<?php namespace Bedard\Photography\Models;

use Model;

class Settings extends Model
{
    use \October\Rain\Database\Traits\Encryptable,
        \October\Rain\Database\Traits\Validation;

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'bedard_photography_settings';

    public $settingsFields = 'fields.yaml';

    /**
     * @var array Encryptable attributes
     */
    protected $encryptable = [
        'stripe_secret_key',
        'stripe_publishable_key',
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'stripe_attempts' => 'integer|min:1',
        'stripe_secret_key' => 'required',
        'stripe_publishable_key' => 'required',
    ];

    /**
     * Get the Stripe attempts number.
     *
     * @return int
     */
    public static function getStripeAttempts()
    {
        return (int) self::get('stripe_attempts', 1);
    }

    /**
     * Get the publishable key.
     *
     * @return string
     */
    public static function getStripePublishableKey()
    {
        return self::get('stripe_publishable_key');
    }

    /**
     * Get the secret key.
     *
     * @return string
     */
    public static function getStripeSecretKey()
    {
        return self::get('stripe_secret_key');
    }
}
