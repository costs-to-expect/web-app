<?php

namespace App\Http\Controllers;

use App\Request\Api;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;

class ExpenseController extends BaseController
{
    protected $display_navigation = true;
    protected $display_add_expense = true;
    protected $nav_active = 'recent';

    public function addExpense(Request $request)
    {
        $this->nav_active = 'add-expense';

        $children = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(Config::get('web.config.api_uri_resources'));

        $sub_categories = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(
                Config::get('web.config.api_uri_categories') .
                '/' . Config::get('web.config.api_category_id_essentials') .
                '/subcategories'
            );

        return view(
            'add-expense',
            [
                'display_navigation' => $this->display_navigation,
                'display_add_expense' => false,
                'nav_active' => $this->nav_active,
                'category_id_essentials' => Config::get('web.config.api_category_id_essentials'),
                'category_id_non_essentials' => Config::get('web.config.api_category_id_non_essentials'),
                'category_id_hobbies_and_interests' => Config::get('web.config.api_category_id_hobbies_and_interests'),
                'sub_categories' => $sub_categories,
                'children' => $children
            ]
        );
    }

    public function expense(Request $request, string $resource_id, string $expense_identifier)
    {
        $expense = null;
        $category = null;
        $sub_category = null;
        $status = null;
        $this->nav_active = 'recent';

        $resource = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(Config::get('web.config.api_uri_resources') .
                $resource_id);

        $expense = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(
                Config::get('web.config.api_uri_resources') .
                $resource_id . '/items/' . $expense_identifier
            );

        $category = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(
                Config::get('web.config.api_uri_resources') .
                $resource_id . '/items/' . $expense_identifier .
                '/category'
            );

        if ($category === null) {
            $status = 'category-not-assigned';
        }

        if ($category !== null) {
            $sub_category = Api::getInstance()
                ->public()
                ->redirectOnFailure('ErrorController@requestStatus')
                ->get(
                    Config::get('web.config.api_uri_resources') .
                    $resource_id . '/items/' . $expense_identifier .
                    '/category/' . $category[0]['id'] . '/subcategory'
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
                    'display_navigation' => $this->display_navigation,
                    'display_add_expense' => $this->display_add_expense,
                    'nav_active' => $this->nav_active,
                    'expense' => $expense,
                    'category' => $category,
                    'sub_category' => $sub_category,
                    'status' => $status,
                    'resource' => $resource
                ]
            );
        }
    }

    public function deleteExpense(Request $request, string $resource_id, string $expense_identifier)
    {
        $expense = null;
        $category = null;
        $sub_category = null;

        $expense_identifier_id = null;
        $expense_category_identifier_id = null;
        $expense_sub_category_identifier_id = null;

        $this->nav_active = 'recent';

        $resource = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(Config::get('web.config.api_uri_resources') .
                $resource_id);

        $expense = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(
                Config::get('web.config.api_uri_resources') .
                $resource_id . '/items/' . $expense_identifier
            );

        if ($expense !== null) {
            $expense_identifier_id = $expense['id'];
        }

        $category = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(
                Config::get('web.config.api_uri_resources') .
                $resource_id . '/items/' . $expense_identifier_id . '/category'
            );

        if ($category !== null) {
            $expense_category_identifier_id = $category['id'];
        }

        if ($category !== null) {
            $sub_category = Api::getInstance()
                ->public()
                ->redirectOnFailure('ErrorController@requestStatus')
                ->get(
                    Config::get('web.config.api_uri_resources') .
                    $resource_id . '/items/' . $expense_identifier .
                    '/category/' . $category['id'] . '/subcategory'
                );

            if ($sub_category !== null) {
                $expense_sub_category_identifier_id = $sub_category['id'];
            }
        }

        if ($expense !== null) {
            return view(
                'delete-expense',
                [
                    'display_navigation' => $this->display_navigation,
                    'display_add_expense' => false,
                    'nav_active' => $this->nav_active,
                    'expense' => $expense,
                    'category' => $category,
                    'sub_category' => $sub_category,
                    'expense_identifier_id' => $expense_identifier_id,
                    'expense_category_identifier_id' => $expense_category_identifier_id,
                    'expense_sub_category_identifier_id' => $expense_sub_category_identifier_id,
                    'resource' => $resource
                ]
            );
        }
    }

    public function expenses(Request $request, string $resource_id)
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
                        $category = Api::getInstance()
                            ->public()
                            ->redirectOnFailure('ErrorController@requestStatus')
                            ->get(
                                Config::get('web.config.api_uri_category') .
                                '/' . $value
                            );

                        if ($category !== null) {
                            $filtering[] .= 'Category: ' . $category['name'];
                        }
                        break;
                    case 'sub_category':
                        $sub_category = Api::getInstance()
                            ->public()
                            ->redirectOnFailure('ErrorController@requestStatus')
                            ->get(
                                Config::get('web.config.api_uri_category') .
                                '/' . $request_parameters['category'] .
                                '/subcategories/' . $value
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

        $uri = Config::get('web.config.api_uri_items') . '?';
        $i = 0;
        foreach ($request_parameters as $parameter => $value) {
            $uri .= ($i === 0 ? null : '&')  . $parameter . '=' . $value;
            $i++;
        }

        $headers = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->head($uri);

        $limit = 50;
        if (
            array_key_exists('X-Total-Count', $headers) === true &&
            intval($headers['X-Total-Count']) < 50
        ) {
            $limit = intval($headers['X-Total-Count']);
        }

        $expenses = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get($uri . '&limit=' . $limit);

        if ($expenses !== null) {
            return view(
                'expenses',
                [
                    'display_navigation' => $this->display_navigation,
                    'display_add_expense' => $this->display_add_expense,
                    'nav_active' => $this->nav_active,
                    'expenses' => $expenses,
                    'filtering' => implode(', ', $filtering),
                    'limit' => $limit
                ]
            );
        }
    }
}
