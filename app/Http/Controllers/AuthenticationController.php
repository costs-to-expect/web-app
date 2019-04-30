<?php

namespace App\Http\Controllers;

use App\Request\Api;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;

class AuthenticationController extends BaseController
{
    protected $display_navigation = false;
    protected $display_add_expense = false;

    public function signIn(Request $request)
    {
        return view(
            'sign-in',
            [
                'display_navigation' => $this->display_navigation,
                'display_add_expense' => $this->display_add_expense
            ]
        );
    }

    public function signOut(Request $request)
    {
        $request->session()->flush();
        $request->session()->save();
        return redirect()->action('AuthenticationController@signIn');
    }

    public function processSignIn(Request $request)
    {
        $client = new Client([
            'base_uri' => Config::get('web.config.api_base_url'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->post(
                Config::get('web.config.api_uri_sign_in'),
                [
                    \GuzzleHttp\RequestOptions::JSON => [
                        'email' => $request->input('email'),
                        'password' => $request->input('password')
                    ]
                ]
            );

            if ($response->getStatusCode() === 200) {
                $children = Api::getInstance()
                    ->public()
                    ->redirectOnFailure('ErrorController@requestStatus')
                    ->get(Config::get('web.config.api_uri_resources'));

                $request->session()->put('bearer', json_decode($response->getBody(), true)['token']);
                $request->session()->put('selected_resource_id', $children[0]['id']);

                return redirect()->action('IndexController@recent', ['resource_id' => $children[1]['id']]);
            } else {
                $request->session()->flush();
                return redirect()->action('AuthenticationController@signIn');
            }
        } catch (ClientException $e) {
            $request->session()->flush();
            $request->session()->save();
            return redirect()->action('AuthenticationController@signIn');
        }
    }
}
