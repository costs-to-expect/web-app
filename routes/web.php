<?php

Route::get('/', 'IndexController@index');
Route::post('/sign-in', 'AuthenticationController@signIn');
Route::get('/recent', 'IndexController@recent');
