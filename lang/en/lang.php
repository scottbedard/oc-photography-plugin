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
    // Categories
    //
    'categories' => [
        'controller' => 'Categories',
        'form' => [
            'name' => 'Name',
            'slug' => 'Slug',
        ],
        'list' => [
            'name' => 'Name',
            'slug' => 'Slug',
        ],
        'model' => 'Category',
    ],

    //
    // Galleries
    //
    'galleries' => [
        'controller' => 'Galleries',
        'form' => [
            'categories' => 'Categories',
            'description' => 'Description',
            'is_watermarked' => 'Watermark photos',
            'name' => 'Name',
            'password' => 'Password',
            'photo_price' => 'Photo price',
            'photos' => 'Upload photos',
            'published_at' => 'Published date',
            'slug' => 'Slug',
            'tabs' => [
                'options' => 'Options',
                'photos' => 'Photos',
                'rates' => 'Rates',
            ],
            'watermark' => 'Select watermark',
            'watermark_text' => 'Watermark text',
        ],
        'list' => [
            'attach_to_category' => 'Add to category',
            'attached_to_category' => 'Successfully added to category.',
            'category_filter' => 'Categories',
            'created_at' => 'Created',
            'name' => 'Name',
            'photo_count' => 'Photos',
            'slug' => 'Slug',
            'updated_at' => 'Last updated',
        ],
        'model' => 'Gallery',
        'slug' => 'Slug',
        'title' => 'Title',
    ],

    //
    // Permissions
    //
    'permissions' => [
        'categories' => 'Manage categories',
        'galleries' => 'Manage galleries',
        'rates' => 'Manage rates',
        'watermarks' => 'Manage watermarks',
    ],

    //
    // Rates
    //
    'rates' => [
        'controller' => 'Rates',
        'form' => [
            'is_active' => 'Rate is active',
            'name' => 'Name',
            'photos' => 'Photo count',
            'price_per_photo' => 'Price per photo',
        ],
        'list' => [
            'name' => 'Name',
            'photos' => 'Photo count',
            'price_per_photo' => 'Price per photo',
        ],
        'model' => 'Rate',
    ],

    //
    // Watermarks
    //
    'watermarks' => [
        'controller' => 'Watermarks',
        'form' => [
            'name' => 'Name',
            'image' => 'Image',
        ],
        'list' => [
            'created_at' => 'Created',
            'name' => 'Name',
            'updated_at' => 'Last updated',
        ],
        'model' => 'Watermark',
    ],
];
