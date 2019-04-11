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
        Route::get('/recent/{resource_id}', 'IndexController@recent');
        Route::get('/summaries/{resource_id}', 'SummaryController@summaries');
        Route::get('/sub-categories-summary/{resource_id}/{category_identifier}', 'SummaryController@subCategoriesSummary');
        Route::get('/tco-summary/{resource_id}', 'SummaryController@categoriesTco');
        Route::get('/months-summary/{resource_id}/{year_identifier}', 'SummaryController@monthsSummary');
        Route::get('/add-expense', 'ExpenseController@addExpense');
        Route::get('/sub-categories/{category_identifier}', 'IndexController@subCategories');
        Route::get('/expense/{resource_id}/{expense_identifier}', 'ExpenseController@expense');
        Route::post('/add-expense', 'ProcessController@processAddExpense');
        Route::get('/delete-expense/{resource_id}/{expense_identifier}', 'ExpenseController@deleteExpense');
        Route::post('/delete-expense/{resource_id}', 'ProcessController@processDeleteExpense');
        Route::get('/version-history', 'IndexController@versionHistory');
        Route::get('/expenses/{resource_id}', 'ExpenseController@expenses');
        Route::get('/error-request-status', 'ErrorController@requestStatus');
        Route::get('/error-exception', 'ErrorController@exception');
    }
);
