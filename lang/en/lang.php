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
            'name' => 'Name',
            'photo_price' => 'Photo price',
            'photos' => 'Upload photos',
            'published_at' => 'Published date',
            'slug' => 'Slug',
        ],
        'list' => [
            'name' => 'Name',
            'photos_count' => 'Photos',
        ],
        'model' => 'Gallery',
        'slug' => 'Slug',
        'title' => 'Title',
    ],
];
