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
            'description' => 'Description',
            'name' => 'Name',
            'photo_price' => 'Photo price',
            'photos' => 'Upload photos',
            'published_at' => 'Published date',
            'slug' => 'Slug',
            'tabs' => [
                'options' => 'Options',
                'photos' => 'Photos',
            ],
        ],
        'list' => [
            'created_at' => 'Created',
            'name' => 'Name',
            'photo_count' => 'Photos',
            'updated_at' => 'Updated',
        ],
        'model' => 'Gallery',
        'slug' => 'Slug',
        'title' => 'Title',
    ],
];
