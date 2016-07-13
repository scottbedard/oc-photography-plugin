<?php

return [

    //
    // Plugin
    //
    'plugin' => [
        'name' => 'Photography',
        'description' => 'A photography oriented ecommerce platform.',
    ],

    //
    // Galleries
    //
    'galleries' => [
        'controller' => 'Galleries',
        'form' => [
            'photo_price' => 'Photo price',
            'photos' => 'Upload photos',
            'published_at' => 'Published date',
            'slug' => 'Slug',
            'title' => 'Title',
        ],
        'model' => 'Gallery',
        'slug' => 'Slug',
        'title' => 'Title',
    ],
];
