<?php

Route::get('/', 'IndexController@index');
Route::get('/sign-in', 'AuthenticationController@signIn');
Route::post('/sign-in', 'AuthenticationController@processSignIn');
Route::get('/recent', 'IndexController@recent');
