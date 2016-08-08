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
        'stripe_secret_key' => 'required',
        'stripe_publishable_key' => 'required',
    ];
}
