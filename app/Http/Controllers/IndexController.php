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
                    'resource_name' => Config::get('web.config.api_resource_name'),
                    'items' => $items
                ]
            );
        }
    }

    public function categoriesSummary(Request $request)
    {
        $categories = null;

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
                    'resource_name' => Config::get('web.config.api_resource_name'),
                    'categories' => $categories
                ]
            );
        }
    }
}
