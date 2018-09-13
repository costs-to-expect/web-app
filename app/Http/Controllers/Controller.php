<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function auth(Request $request)
    {
        $client = new Client([
            'base_uri' => env('https://api.costs-to-expect.com/v1/auth/login'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $post = $client->request('POST', 'https://api.costs-to-expect.com/v1/auth/login', [
                'json' => [
                    'email' => 'dean@g3d-development.com',
                    'password' => '*'
                ]
            ]);

            $response = json_decode($post->getBody());

            //va($response['token']);

            var_dump($response->token);
        } catch (ClientException $e) {
            dd('failed');
        }
    }
}
