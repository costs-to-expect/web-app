<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AuthenticationController extends BaseController
{
    public function signIn(Request $request)
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
                $request->session()->put('bearer', json_decode($response->getBody(), true)['token']);
            } else {
                $request->session()->flush();
            }
        } catch (ClientException $e) {
            $request->session()->flush();
            $request->session()->save();
            dd($e->getCode());
        }
    }

    public function user(Request $request)
    {
        $client = new Client([
            'base_uri' => 'https://api.costs-to-expect.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . $request->session()->get('bearer'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->get('auth/user');

            if ($response->getStatusCode() === 200) {
                var_dump($request->session()->get('bearer'));
            }
        } catch (ClientException $e) {
            dd($e->getCode());
        }
    }
}
