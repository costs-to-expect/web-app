<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;

class ProcessController extends BaseController
{
    protected $display_nav_options = true;
    protected $nav_active = 'recent';

    public function processAddExpense(Request $request)
    {
        $item = null;
        $item_category = null;
        $item_sub_category = null;

        $client = new Client([
            'base_uri' => Config::get('web.config.api_base_url'),
            'headers' => [
                'Authorization' => 'Bearer ' . $request->session()->get('bearer'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->post(
                Config::get('web.config.api_uri_items'),
                [
                    \GuzzleHttp\RequestOptions::JSON => [
                        'description' => $request->input('description'),
                        'effective_date' => $request->input('effective_date'),
                        'total' => $request->input('total'),
                        'percentage' => $request->input('allocation')
                    ]
                ]
            );

            if ($response->getStatusCode() === 201) {
                $item = json_decode($response->getBody(), true);
            } else {
                // Check for 422 (validation) and then display below for general errors
                $request->session()->flash('status', 'expense-not-added-item');
                return redirect()->action('IndexController@recent');
            }
        } catch (ClientException $e) {
            $request->session()->flash('status', 'api-error');
            $request->session()->flash('status-line', __LINE__);
            return redirect()->action('IndexController@recent');
        }

        try {
            $response = $client->post(
                Config::get('web.config.api_uri_items') . '/' . $item['id'] . '/category',
                [
                    \GuzzleHttp\RequestOptions::JSON => [
                        'category_id' => $request->input('category_id')
                    ]
                ]
            );

            if ($response->getStatusCode() === 201) {
                $item_category = json_decode($response->getBody(), true);
            } else {
                // Check for 422 (validation) and then display below for general errors
                $request->session()->flash('status', 'expense-not-added-item-category');
                return redirect()->action('IndexController@recent');
            }
        } catch (ClientException $e) {
            $request->session()->flash('status', 'api-error');
            $request->session()->flash('status-line', __LINE__);
            return redirect()->action('IndexController@recent');
        }

        try {
            $response = $client->post(
                Config::get('web.config.api_uri_items') . '/' .
                $item['id'] . '/category/' . $item_category['id'] . '/sub_category',
                [
                    \GuzzleHttp\RequestOptions::JSON => [
                        'sub_category_id' => $request->input('sub_category_id')
                    ]
                ]
            );

            if ($response->getStatusCode() === 201) {
                $item_sub_category = json_decode($response->getBody(), true);
            } else {
                // Check for 422 (validation) and then display below for general errors
                $request->session()->flash('status', 'expense-not-added-item-sub-category');
                return redirect()->action('IndexController@recent');
            }
        } catch (ClientException $e) {
            $request->session()->flash('status', 'api-error');
            $request->session()->flash('status-line', __LINE__);
            return redirect()->action('IndexController@recent');
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
        $client = new Client([
            'base_uri' => Config::get('web.config.api_base_url'),
            'headers' => [
                'Authorization' => 'Bearer ' . $request->session()->get('bearer'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $deleted_sub_category = false;
        $deleted_category = false;
        $deleted_expense = false;

        $expense_identifier = $request->input('expense_identifier_id');
        $expense_category_identifier = $request->input('expense_category_identifier_id');
        $expense_sub_category_identifier = $request->input('expense_sub_category_identifier_id');

        if ($expense_sub_category_identifier !== null) {
            try {
                $response = $client->delete(
                    Config::get('web.config.api_uri_items') . '/' .
                    $expense_identifier . '/category/' . $expense_category_identifier .
                    '/sub_category/' . $expense_sub_category_identifier
                );

                if ($response->getStatusCode() === 204) {
                    $deleted_sub_category = true;
                }
            } catch (ClientException $e) {
                // Ignore for now until logging added
            }
        } else {
            $deleted_sub_category = true;
        }

        if ($deleted_sub_category === true && $expense_category_identifier !== null) {
            try {
                $response = $client->delete(
                    Config::get('web.config.api_uri_items') . '/' .
                    $expense_identifier . '/category/' . $expense_category_identifier
                );

                if ($response->getStatusCode() === 204) {
                    $deleted_category = true;
                }
            } catch (ClientException $e) {
                // Ignore for now until logging added
            }
        } else {
            $deleted_category = true;
        }

        if ($deleted_category === true && $expense_identifier !== null) {
            try {
                $response = $client->delete(
                    Config::get('web.config.api_uri_items') . '/' . $expense_identifier
                );

                if ($response->getStatusCode() === 204) {
                    $deleted_expense = true;
                }
            } catch (ClientException $e) {
                // Ignore for now until logging added
            }
        } else {
            $deleted_expense = true;
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
