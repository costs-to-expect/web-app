<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        return view(
            'index',
            [
                'resource' => 'Resource name'
            ]
        );
    }
}
