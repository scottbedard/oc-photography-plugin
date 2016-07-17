<?php namespace Bedard\Photography;

use Backend;
use System\Classes\PluginBase;

/**
 * Photography Plugin Information File.
 */
class Plugin extends PluginBase
{
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
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'bedard.photography.galleries' => [
                'tab'   => 'bedard.photography::lang.plugin.name',
                'label' => 'bedard.photography::lang.permissions.galleries'
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
                    'galleries' => [
                        'label'         => 'bedard.photography::lang.galleries.controller',
                        'icon'          => 'icon-folder-o',
                        'url'           => Backend::url('bedard/photography/galleries'),
                        'permissions'   => ['bedard.photography.access_galleries'],
                    ],
                    'watermarks' => [
                        'label'         => 'bedard.photography::lang.watermarks.controller',
                        'icon'          => 'icon-copyright',
                        'url'           => Backend::url('bedard/photography/watermarks'),
                        'permissions'   => ['bedard.photography.access_watermarks'],
                    ],
                ],
            ],
        ];
    }
}
