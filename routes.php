<?php

//
// Categories
//
Route::resource('api/bedard/photography/categories', 'Bedard\Photography\Api\Category');

//
// Galleries
//
Route::resource('api/bedard/photography/galleries', 'Bedard\Photography\Api\Galleries');

//
// Orders
//
Route::get('api/bedard/photography/orders/attach/{id}', 'Bedard\Photography\Api\Orders@attach');
