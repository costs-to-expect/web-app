<?php

namespace App\Http\Controllers;

use App\Request\Api;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;

class ExpenseController extends BaseController
{
    protected $display_nav_options = true;
    protected $nav_active = 'recent';

    public function addExpense(Request $request)
    {
        $this->nav_active = 'add-expense';

        $sub_categories = Api::public()->get(
            Config::get('web.config.api_uri_categories') .
            '/' . Config::get('web.config.api_category_id_essentials') .
            '/sub_categories',
            'IndexController@index'
        );

        return view(
            'add-expense',
            [
                'display_nav_options' => $this->display_nav_options,
                'nav_active' => $this->nav_active,
                'resource_name' => Config::get('web.config.api_resource_name'),
                'category_id_essentials' => Config::get('web.config.api_category_id_essentials'),
                'category_id_non_essentials' => Config::get('web.config.api_category_id_non_essentials'),
                'category_id_hobbies_and_interests' => Config::get('web.config.api_category_id_hobbies_and_interests'),
                'sub_categories' => $sub_categories
            ]
        );
    }

    public function expense(Request $request, string $expense_identifier)
    {
        $expense = null;
        $category = null;
        $sub_category = null;
        $status = null;
        $this->nav_active = 'recent';

        $expense = Api::public()->get(
            Config::get('web.config.api_uri_items') . '/' .
            $expense_identifier,
            'IndexController@index'
        );

        $category = Api::public()->get(
            Config::get('web.config.api_uri_items') . '/' .
            $expense_identifier . '/category',
            'IndexController@index'
        );

        if ($category === null) {
            $status = 'category-not-assigned';
        }

        if ($category !== null) {
            $sub_category = Api::public()->get(
                Config::get('web.config.api_uri_items') . '/' .
                $expense_identifier . '/category/' . $category['id'] .
                '/sub_category',
                'IndexController@index'
            );

            if ($sub_category === null) {
                $status = 'sub-category-not-assigned';
            }
        } else {
            $sub_category = null;
        }


        if ($expense !== null) {
            return view(
                'expense',
                [
                    'display_nav_options' => $this->display_nav_options,
                    'nav_active' => $this->nav_active,
                    'expense' => $expense,
                    'category' => $category,
                    'sub_category' => $sub_category,
                    'status' => $status
                ]
            );
        }
    }

    public function deleteExpense(Request $request, string $expense_identifier)
    {
        $expense = null;
        $category = null;
        $sub_category = null;

        $expense_identifier_id = null;
        $expense_category_identifier_id = null;
        $expense_sub_category_identifier_id = null;

        $this->nav_active = 'recent';

        $expense = Api::public()->get(
            Config::get('web.config.api_uri_items') . '/' .
            $expense_identifier,
            'IndexController@index'
        );

        if ($expense !== null) {
            $expense_identifier_id = $expense['id'];
        }

        $category = Api::public()->get(
            Config::get('web.config.api_uri_items') . '/' .
            $expense_identifier . '/category',
            'IndexController@index'
        );

        if ($category !== null) {
            $expense_category_identifier_id = $category['id'];
        }

        if ($category !== null) {
            $sub_category = Api::public()->get(
                Config::get('web.config.api_uri_items') . '/' .
                $expense_identifier . '/category/' . $category['id'] .
                '/sub_category',
                'IndexController@index'
            );

            if ($sub_category !== null) {
                $expense_sub_category_identifier_id = $sub_category['id'];
            }
        }

        if ($expense !== null) {
            return view(
                'delete-expense',
                [
                    'display_nav_options' => $this->display_nav_options,
                    'nav_active' => $this->nav_active,
                    'expense' => $expense,
                    'category' => $category,
                    'sub_category' => $sub_category,
                    'expense_identifier_id' => $expense_identifier_id,
                    'expense_category_identifier_id' => $expense_category_identifier_id,
                    'expense_sub_category_identifier_id' => $expense_sub_category_identifier_id
                ]
            );
        }
    }

    public function expenses(Request $request)
    {
        $expenses = null;

        $allowed = ['year', 'month', 'category', 'sub_category'];
        $request_parameters = [];
        $filtering = [];
        $parameters = $request->all();

        foreach ($parameters as $parameter => $value) {
            if (
                in_array($parameter, $allowed) === true &&
                $value !== null
            ) {
                switch ($parameter) {
                    case 'year':
                        $filtering[] = 'Year: ' . $value;
                        break;
                    case 'month':
                        $filtering[] = 'Month: ' .
                            date(
                                "F",
                                mktime(
                                    0,
                                    0,
                                    0,
                                    $value,
                                    5
                                )
                            );
                        break;
                    case 'category':
                        $category = Api::public()->get(
                            Config::get('web.config.api_uri_category') .
                            '/' . $value,
                            'IndexController@index'
                        );

                        if ($category !== null) {
                            $filtering[] .= 'Category: ' . $category['name'];
                        }
                        break;
                    case 'sub_category':
                        $sub_category = Api::public()->get(
                            Config::get('web.config.api_uri_category') .
                            '/' . $request_parameters['category'] .
                            '/sub_categories/' . $value,
                            'IndexController@index'
                        );

                        if ($sub_category !== null) {
                            $filtering[] .= 'Sub category: ' . $sub_category['name'];
                        }
                        break;
                    default:
                        break;
                }

                $request_parameters[$parameter] = $value;
            }
        }

        $uri = Config::get('web.config.api_uri_items') . '?limit=50';
        foreach ($request_parameters as $parameter => $value) {
            $uri .= '&' . $parameter . '=' . $value;
        }

        $expenses = Api::public()->get($uri, 'IndexController@index');

        if ($expenses !== null) {
            return view(
                'expenses',
                [
                    'display_nav_options' => $this->display_nav_options,
                    'nav_active' => $this->nav_active,
                    'resource_name' => Config::get('web.config.api_resource_name'),
                    'expenses' => $expenses,
                    'filtering' => implode(', ', $filtering),
                    'count' => count($expenses)
                ]
            );
        }
    }
}
