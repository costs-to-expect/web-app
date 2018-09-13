<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;


class Authentication extends BaseController
{
    public function login(Request $request)
    {
        $client = new Client([
            'base_uri' => 'https://api.costs-to-expect.com/v1/',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->post(
                'auth/login',
                [
                    \GuzzleHttp\RequestOptions::JSON => [
                        'email' => 'dean@g3d-development.com',
                        'password' => ''
                    ]
                ]
            );

            if ($response->getStatusCode() === 200) {

                Session::put('bearer', json_decode($response->getBody(), true)['token']);


                var_dump(json_decode($response->getBody(), true)['token']);
            }
        } catch (ClientException $e) {
            dd($e->getCode());
        }
    }

    public function user(Request $request)
    {
        $client = new Client([
            'base_uri' => 'https://api.costs-to-expect.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . Session::get('bearer'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->get('auth/user');

            if ($response->getStatusCode() === 200) {
                var_dump(json_decode($response->getBody(), true));
            }
        } catch (ClientException $e) {
            dd($e->getCode());
        }
    }
}
