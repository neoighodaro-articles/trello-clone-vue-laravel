<?php

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/category/{category}/tasks', 'CategoryController@tasks');
    Route::resource('/category', 'CategoryController');
    Route::resource('/task', 'TaskController');
});
