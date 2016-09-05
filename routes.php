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
Route::get('api/bedard/photography/orders/current', 'Bedard\Photography\Api\Orders@current');
Route::post('api/bedard/photography/orders/process', 'Bedard\Photography\Api\Orders@process');
Route::get('api/bedard/photography/orders/download/{token}', 'Bedard\Photography\Api\Orders@download');
Route::post('api/bedard/photography/orders/attach/{id}', 'Bedard\Photography\Api\Orders@attach');
Route::delete('api/bedard/photography/orders/detach/{id}', 'Bedard\Photography\Api\Orders@detach');
Route::get('api/bedard/photography/orders/file/{id}/{diskName}', 'Bedard\Photography\Api\Orders@file');
