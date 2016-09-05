<?php namespace Bedard\Photography;

use App;
use Backend;
use Bedard\Photography\Models\Settings;
use Illuminate\Foundation\AliasLoader;
use Lang;
use Stripe;
use System\Classes\PluginBase;

/**
 * Photography Plugin Information File.
 */
class Plugin extends PluginBase
{
    /**
     * Boot up the plugin.
     *
     * @return void
     */
    public function boot()
    {
        // Register Intervention\Image
        App::register('\Intervention\Image\ImageServiceProvider');
        $alias = AliasLoader::getInstance();
        $alias->alias('Image', '\Intervention\Image\Facades\Image');

        // Set up Stripe API keys
        $stripeKey = Settings::getStripeSecretKey();
        Stripe\Stripe::setApiKey($stripeKey);
    }

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'          => 'bedard.photography::lang.plugin.name',
            'description'   => 'bedard.photography::lang.plugin.description',
            'author'        => 'Scott Bedard',
            'icon'          => 'icon-camera-retro',
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [];
    }

    /**
     * Register mail templates.
     *
     * @return array
     */
    public function registerMailTemplates()
    {
        return [
            'bedard.photography::mail.complete' => Lang::get('bedard.photography::lang.mail.complete_description'),
            'bedard.photography::mail.failed' => Lang::get('bedard.photography::lang.mail.failed_description'),
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'bedard.photography.orders' => [
                'tab'   => 'bedard.photography::lang.plugin.name',
                'label' => 'bedard.photography::lang.permissions.orders',
            ],
            'bedard.photography.categories' => [
                'tab'   => 'bedard.photography::lang.plugin.name',
                'label' => 'bedard.photography::lang.permissions.categories',
            ],
            'bedard.photography.galleries' => [
                'tab'   => 'bedard.photography::lang.plugin.name',
                'label' => 'bedard.photography::lang.permissions.galleries',
            ],
            'bedard.photography.rates' => [
                'tab'   => 'bedard.photography::lang.plugin.name',
                'label' => 'bedard.photography::lang.permissions.rates',
            ],
            'bedard.photography.watermarks' => [
                'tab'   => 'bedard.photography::lang.plugin.name',
                'label' => 'bedard.photography::lang.permissions.watermarks',
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'photography' => [
                'label'         => 'Photography',
                'url'           => Backend::url('bedard/photography/galleries'),
                'icon'          => 'icon-camera-retro',
                'permissions'   => ['bedard.photography.*'],
                'order'         => 500,
                'sideMenu' => [
                    'orders' => [
                        'label'         => 'bedard.photography::lang.orders.controller',
                        'icon'          => 'icon-shopping-cart',
                        'url'           => Backend::url('bedard/photography/orders'),
                        'permissions'   => ['bedard.photography.access_orders'],
                    ],
                    'galleries' => [
                        'label'         => 'bedard.photography::lang.galleries.controller',
                        'icon'          => 'icon-camera-retro',
                        'url'           => Backend::url('bedard/photography/galleries'),
                        'permissions'   => ['bedard.photography.access_galleries'],
                    ],
                    'categories' => [
                        'label'         => 'bedard.photography::lang.categories.controller',
                        'icon'          => 'icon-folder-o',
                        'url'           => Backend::url('bedard/photography/categories'),
                        'permissions'   => ['bedard.photography.access_categories'],
                    ],
                    'rates' => [
                        'label'         => 'bedard.photography::lang.rates.controller',
                        'icon'          => 'icon-dollar',
                        'url'           => Backend::url('bedard/photography/rates'),
                        'permissions'   => ['bedard.photography.access_rates'],
                    ],
                    'watermarks' => [
                        'label'         => 'bedard.photography::lang.watermarks.controller',
                        'icon'          => 'icon-paint-brush',
                        'url'           => Backend::url('bedard/photography/watermarks'),
                        'permissions'   => ['bedard.photography.access_watermarks'],
                    ],
                    'settings' => [
                        'label'         => 'bedard.photography::lang.settings.controller',
                        'icon'          => 'icon-cog',
                        'url'           => Backend::url('system/settings/update/bedard/photography/settings'),
                        'permissions'   => ['bedard.photography.settings'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Register settings pages.
     *
     * @return  array
     */
    public function registerSettings()
    {
        return [
            'settings' => [
                'label'         => 'bedard.photography::lang.settings.controller',
                'description'   => 'bedard.photography::lang.settings.description',
                'category'      => 'bedard.photography::lang.plugin.name',
                'class'         => 'Bedard\Photography\Models\Settings',
                'permissions'   => ['bedard.photography.settings'],
                'icon'          => 'icon-cog',
                'order'         => 100,
            ],
        ];
    }
}
