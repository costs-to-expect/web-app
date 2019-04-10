<?php

namespace App\Http\Controllers;

use App\Request\Api;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;

class ProcessController extends BaseController
{
    public function processAddExpense(Request $request)
    {
        $item = null;
        $item_category = null;
        $item_sub_category = null;

        $item = Api::getInstance()
            ->protected()
            ->redirectOnFailure('IndexController@recent')
            ->post(
                Config::get('web.config.api_uri_resources') .
                    $request->input('resource_id') . '/items',
                [
                    'description' => $request->input('description'),
                    'effective_date' => $request->input('effective_date'),
                    'total' => $request->input('total'),
                    'percentage' => $request->input('allocation')
                ],
                'expense-not-added-item'
            );

        if ($item !== null) {
            $item_category = Api::getInstance()
                ->protected()
                ->redirectOnFailure('IndexController@recent')
                ->post(
                    Config::get('web.config.api_uri_resources') .
                    $request->input('resource_id') . '/items/' . $item['id'] . '/category',
                    [
                        'category_id' => $request->input('category_id')
                    ],
                    'expense-not-added-item-category'
                );
        }

        if ($item !== null && $item_category !== null) {
            $item_sub_category = Api::getInstance()
                ->protected()
                ->redirectOnFailure('IndexController@recent')
                ->post(
                    Config::get('web.config.api_uri_resources') .
                    $request->input('resource_id') . '/items/' . $item['id'] .
                    '/category/' . $item_category['id'] . '/subcategory',
                    [
                        'sub_category_id' => $request->input('sub_category_id')
                    ],
                    'expense-not-added-item-sub-category'
                );
        }

        if ($item !== null && $item_category !== null && $item_sub_category !== null) {
            $request->session()->flash('status', 'expense-added');
            return redirect()->action('IndexController@recent');
        } else {
            $request->session()->flash('status', 'expense-not-added');
            return redirect()->action('IndexController@recent');
        }
    }

    public function processDeleteExpense(Request $request)
    {
        $deleted_sub_category = false;
        $deleted_category = false;
        $deleted_expense = false;

        $expense_identifier = $request->input('expense_identifier_id');
        $expense_category_identifier = $request->input('expense_category_identifier_id');
        $expense_sub_category_identifier = $request->input('expense_sub_category_identifier_id');

        if ($expense_sub_category_identifier !== null) {
            $deleted_sub_category = Api::getInstance()
                ->protected()
                ->delete(
                    Config::get('web.config.api_uri_items') . '/' .
                    $expense_identifier . '/category/' . $expense_category_identifier .
                    '/subcategory/' . $expense_sub_category_identifier
                );
        }

        if ($deleted_sub_category === true && $expense_category_identifier !== null) {
            $deleted_category = Api::getInstance()
                ->protected()
                ->delete(
                    Config::get('web.config.api_uri_items') . '/' .
                    $expense_identifier . '/category/' . $expense_category_identifier
                );
        }

        if ($deleted_category === true && $expense_identifier !== null) {
            $deleted_expense = Api::getInstance()
                ->protected()
                ->delete(
                    Config::get('web.config.api_uri_items') . '/' .
                    $expense_identifier
                );
        }

        if ($deleted_expense === true && $deleted_category === true && $deleted_sub_category === true) {
            $request->session()->flash('status', 'expense-deleted');
            return redirect()->action('IndexController@recent');
        } else {
            $request->session()->flash('status', 'expense-not-deleted');
            return redirect()->action('ExpenseController@expense', ['expense_identifier' => $expense_identifier]);
        }
    }
}
