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
        Route::get('/summaries', 'IndexController@summaries');
        Route::get('/sub-categories-summary/{category_identifier}', 'IndexController@subCategoriesSummary');
        Route::get('/tco-summary', 'IndexController@categoriesTco');
        Route::get('/add-expense', 'IndexController@addExpense');
        Route::get('/sub-categories/{category_identifier}', 'IndexController@subCategories');
        Route::get('/expense/{expense_identifier}', 'IndexController@expense');
        Route::post('/add-expense', 'IndexController@processAddExpense');
        Route::get('/delete-expense/{expense_identifier}', 'IndexController@deleteExpense');
        Route::post('/delete-expense', 'IndexController@processDeleteExpense');
    }
);
