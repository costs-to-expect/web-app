<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;

class IndexController extends BaseController
{
    protected $display_nav_options = true;
    protected $nav_active = 'recent';

    public function index(Request $request)
    {
        return redirect()->action('IndexController@recent');
    }

    public function recent(Request $request)
    {
        $expenses = null;

        $client = new Client([
            'base_uri' => Config::get('web.config.api_base_url'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->get(Config::get('web.config.api_uri_items') . '?limit=5');

            if ($response->getStatusCode() === 200) {
                $expenses = json_decode($response->getBody(), true);
            }
        } catch (ClientException $e) {
            return redirect()->action('IndexController@index');
        }

        if ($expenses !== null) {
            return view(
                'recent',
                [
                    'display_nav_options' => $this->display_nav_options,
                    'nav_active' => $this->nav_active,
                    'resource_name' => Config::get('web.config.api_resource_name'),
                    'expenses' => $expenses
                ]
            );
        }
    }

    public function categoriesSummary(Request $request)
    {
        $categories = null;
        $this->nav_active = 'categories-summary';

        $client = new Client([
            'base_uri' => Config::get('web.config.api_base_url'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->get(Config::get('web.config.api_uri_categories_summary'));

            if ($response->getStatusCode() === 200) {
                $categories = json_decode($response->getBody(), true);
            }
        } catch (ClientException $e) {
            return redirect()->action('IndexController@index');
        }

        if ($categories !== null) {
            return view(
                'categories-summary',
                [
                    'display_nav_options' => $this->display_nav_options,
                    'nav_active' => $this->nav_active,
                    'resource_name' => Config::get('web.config.api_resource_name'),
                    'categories' => $categories
                ]
            );
        }
    }

    public function categoriesTco(Request $request)
    {
        $tco = null;
        $this->nav_active = 'tco-summary';

        $client = new Client([
            'base_uri' => Config::get('web.config.api_base_url'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->get(Config::get('web.config.api_uri_categories_tco'));

            if ($response->getStatusCode() === 200) {
                $tco = json_decode($response->getBody(), true);
            }
        } catch (ClientException $e) {
            return redirect()->action('IndexController@index');
        }

        if ($tco !== null) {
            return view(
                'tco-summary',
                [
                    'display_nav_options' => $this->display_nav_options,
                    'nav_active' => $this->nav_active,
                    'resource_name' => Config::get('web.config.api_resource_name'),
                    'tco' => $tco
                ]
            );
        }
    }

    public function subCategoriesSummary(Request $request, string $category_identifier)
    {
        $category = null;
        $sub_categories = null;
        $this->nav_active = 'categories-summary';

        $client = new Client([
            'base_uri' => Config::get('web.config.api_base_url'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->get(
                Config::get('web.config.api_uri_categories_summary') .
                '/' . $category_identifier . '/sub_categories'
            );

            if ($response->getStatusCode() === 200) {
                $sub_categories = json_decode($response->getBody(), true);
            }
        } catch (ClientException $e) {
            return redirect()->action('IndexController@index');
        }

        try {
            $response = $client->get(
                Config::get('web.config.api_uri_category') .
                '/' . $category_identifier
            );

            if ($response->getStatusCode() === 200) {
                $category = json_decode($response->getBody(), true);
            }
        } catch (ClientException $e) {
            return redirect()->action('IndexController@index');
        }

        if ($category === null || $sub_categories !== null) {
            return view(
                'sub-categories-summary',
                [
                    'display_nav_options' => $this->display_nav_options,
                    'nav_active' => $this->nav_active,
                    'resource_name' => Config::get('web.config.api_resource_name'),
                    'category' => $category,
                    'sub_categories' => $sub_categories
                ]
            );
        }
    }

    public function addExpense(Request $request)
    {
        $this->nav_active = 'add-expense';
        $categories = [];

        $client = new Client([
            'base_uri' => Config::get('web.config.api_base_url'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->get(
                Config::get('web.config.api_uri_categories') .
                '/' . Config::get('web.config.api_category_id_essentials') .
                '/sub_categories'
            );

            if ($response->getStatusCode() === 200) {
                $categories = json_decode($response->getBody(), true);
            }
        } catch (ClientException $e) {
            return redirect()->action('IndexController@index');
        }

        return view(
            'add-expense',
            [
                'display_nav_options' => $this->display_nav_options,
                'nav_active' => $this->nav_active,
                'resource_name' => Config::get('web.config.api_resource_name'),
                'category_id_essentials' => Config::get('web.config.api_category_id_essentials'),
                'category_id_non_essentials' => Config::get('web.config.api_category_id_non_essentials'),
                'category_id_hobbies_and_interests' => Config::get('web.config.api_category_id_hobbies_and_interests'),
                'categories' => $categories
            ]
        );
    }

    public function subCategories(Request $request, string $category_identifier)
    {
        $sub_categories = [];

        $client = new Client([
            'base_uri' => Config::get('web.config.api_base_url'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->get(
                Config::get('web.config.api_uri_categories') .
                '/' . $category_identifier . '/sub_categories'
            );

            if ($response->getStatusCode() === 200) {
                $sub_categories = json_decode($response->getBody(), true);
            }
        } catch (ClientException $e) {
            return response()->json(
                [
                    'sub_categories' => $sub_categories
                ],
                200
            );
        }

        return response()->json($sub_categories, 200);
    }

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
                        'total' => $request->input('total')
                    ]
                ]
            );

            if ($response->getStatusCode() === 201) {
                $item = json_decode($response->getBody(), true);
            } else {
                die('Not 201, add item');
            }
        } catch (ClientException $e) {
            die('Failed to add item');
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
                die('Not 201, add category');
            }
        } catch (ClientException $e) {
           echo $e->getMessage();
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
                die('Not 201, add sub category');
            }
        } catch (ClientException $e) {
            echo $e->getMessage();
        }

        if ($item !== null && $item_category !== null && $item_sub_category) {
            return redirect()->action('IndexController@recent');
        } else {
            // Relevant 404 error
            var_dump($item);
            var_dump($item_category);
            var_dump($item_sub_category);
            die;
        }
    }

    public function expense(Request $request, string $expense_identifier)
    {
        $expense = null;
        $this->nav_active = 'expense';

        $client = new Client([
            'base_uri' => Config::get('web.config.api_base_url'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->get(Config::get('web.config.api_uri_items') .
                '/' . $expense_identifier);

            if ($response->getStatusCode() === 200) {
                $expense = json_decode($response->getBody(), true);
            }
        } catch (ClientException $e) {
            return redirect()->action('IndexController@recent');
        }

        if ($expense !== null) {
            return view(
                'expense',
                [
                    'display_nav_options' => $this->display_nav_options,
                    'nav_active' => $this->nav_active,
                    'expense' => $expense
                ]
            );
        }
    }
}
