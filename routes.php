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
Route::post('api/bedard/photography/orders/attach/{id}', 'Bedard\Photography\Api\Orders@attach');
Route::delete('api/bedard/photography/orders/detach/{id}', 'Bedard\Photography\Api\Orders@detach');
