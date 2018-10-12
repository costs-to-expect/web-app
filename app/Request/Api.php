<?php

namespace App\Request;

use Config;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

/**
 * Request helper class for connecting to the Costs to Expect API
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright Dean Blackborough 2018
 * @license https://github.com/costs-to-expect/api/blob/master/LICENSE
 * @package App\Request
 */
class Api
{
    /**
     * @var \GuzzleHttp\Client
     */
    private static $client = null;

    /**
     * Set up a protected connection to the Costs to Expect API
     *
     * @return Api
     */
    public static function protected(): Api
    {

    }

    /**
     * Set up a public connection to the Costs to Expect API
     *
     * @return Api
     */
    public static function public(): Api
    {
        self::$client = new Client([
            'base_uri' => Config::get('web.config.api_base_url'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        return new static();
    }

    /**
     * Make a GET request to the API
     *
     * @param string $uri URI to make GET request ro
     * @param string $redirectAction Action to redirect to upon client exception
     *
     * @return mixed
     */
    public static function get($uri, $redirectAction)
    {
        $content = null;

        try {
            $response = self::$client->get($uri);

            if ($response->getStatusCode() === 200) {
                $content = json_decode($response->getBody(), true);
            }
        } catch (ClientException $e) {
            redirect()->action($redirectAction)->send();
            exit;
        }

        return $content;
    }
}
