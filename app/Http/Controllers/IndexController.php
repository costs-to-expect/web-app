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
        $items = null;

        $client = new Client([
            'base_uri' => Config::get('web.config.api_base_url'),
            'headers' => [
                //'Authorization' => 'Bearer ' . $request->session()->get('bearer'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->get(Config::get('web.config.api_uri_recent') . '?limit=5');

            if ($response->getStatusCode() === 200) {
                $items = (json_decode($response->getBody(), true));
            }
        } catch (ClientException $e) {
            return redirect()->action('IndexController@index');
        }

        if ($items !== null) {
            return view(
                'recent',
                [
                    'display_nav_options' => $this->display_nav_options,
                    'nav_active' => $this->nav_active,
                    'resource_name' => Config::get('web.config.api_resource_name'),
                    'items' => $items
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
                //'Authorization' => 'Bearer ' . $request->session()->get('bearer'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->get(Config::get('web.config.api_uri_categories_summary'));

            if ($response->getStatusCode() === 200) {
                $categories = (json_decode($response->getBody(), true));
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
                //'Authorization' => 'Bearer ' . $request->session()->get('bearer'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->get(Config::get('web.config.api_uri_categories_tco'));

            if ($response->getStatusCode() === 200) {
                $tco = (json_decode($response->getBody(), true));
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
                //'Authorization' => 'Bearer ' . $request->session()->get('bearer'),
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
                $sub_categories = (json_decode($response->getBody(), true));
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
                $category = (json_decode($response->getBody(), true));
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
}
