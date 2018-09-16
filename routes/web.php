<?php

Route::get('/', 'IndexController@index');
Route::get('/sign-in', 'AuthenticationController@signIn');
Route::get('/sign-out', 'AuthenticationController@signOut');
Route::post('/sign-in', 'AuthenticationController@processSignIn');

Route::group(
    [
        'middleware' => [
            'check.for.session'
        ]
    ],
    function () {
        Route::get('/recent', 'IndexController@recent');
        Route::get('/categories-summary', 'IndexController@categoriesSummary');
        Route::get('/sub-categories-summary/{category_identifier}', 'IndexController@subCategoriesSummary');
        Route::get('/tco-summary', 'IndexController@categoriesTco');
        Route::get('/add-expense', 'IndexController@addExpense');
    }
);
