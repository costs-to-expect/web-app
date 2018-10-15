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
        Route::get('/summaries', 'SummaryController@summaries');
        Route::get('/sub-categories-summary/{category_identifier}', 'SummaryController@subCategoriesSummary');
        Route::get('/tco-summary', 'SummaryController@categoriesTco');
        Route::get('/months-summary/{year_identifier}', 'SummaryController@monthsSummary');
        Route::get('/add-expense', 'ExpenseController@addExpense');
        Route::get('/sub-categories/{category_identifier}', 'IndexController@subCategories');
        Route::get('/expense/{expense_identifier}', 'ExpenseController@expense');
        Route::post('/add-expense', 'ProcessController@processAddExpense');
        Route::get('/delete-expense/{expense_identifier}', 'ExpenseController@deleteExpense');
        Route::post('/delete-expense', 'ProcessController@processDeleteExpense');
        Route::get('/version-history', 'IndexController@versionHistory');
        Route::get('/expenses', 'ExpenseController@expenses');
        Route::get('/expenses', 'ExpenseController@expenses');
        Route::get('/error-request-status', 'ErrorController@requestStatus');
        Route::get('/error-exception', 'ErrorController@exception');
    }
);
