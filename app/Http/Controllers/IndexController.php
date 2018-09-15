<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        /*$request->session()->flush();
        $request->session()->save();*/

        return view(
            'index',
            [
                'resource' => 'Resource name'
            ]
        );
    }

    public function recent(Request $request)
    {
        if ($request->session()->has('bearer') === false) {
            return redirect()->action('IndexController@index');
        }

        //echo Config::get('web.config.api_uri_items');
        echo  'Bearer ' . $request->session()->get('bearer');

        $client = new Client([
            'base_uri' => Config::get('web.config.api_base_url'),
            'headers' => [
                //'Authorization' => 'Bearer ' . $request->session()->get('bearer'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->get(Config::get('web.config.api_uri_recent'));

            if ($response->getStatusCode() === 200) {
                dd(json_decode($response->getBody(), true));
            }
        } catch (ClientException $e) {
            return redirect()->action('IndexController@index');
        }
    }
}
