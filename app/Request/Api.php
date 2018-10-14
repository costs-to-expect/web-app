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
        self::$client = new Client([
            'base_uri' => Config::get('web.config.api_base_url'),
            'headers' => [
                'Authorization' => 'Bearer ' . request()->session()->get('bearer'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        return new static();
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
     * @param string $uri URI to make GET request to
     * @param string $redirectAction Action to redirect to upon client exception
     *
     * @return mixed
     */
    public static function get(string $uri, string $redirectAction)
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

    /**
     * Make a POST request to the API
     *
     * @param string $uri URI to make POST request to
     * @param array $payload Payload to POST to the API
     * @param string $redirectAction Action to redirect to upon client exception
     * @param string $flash_status Status to store in flash session upon error
     *
     * @return mixed
     */
    public static function post(
        string $uri,
        array $payload,
        string $redirectAction,
        string $flash_status
    ) {
        $content = null;

        try {
            $response = self::$client->post(
                $uri,
                [\GuzzleHttp\RequestOptions::JSON => $payload]
            );

            if ($response->getStatusCode() === 201) {
                $content = json_decode($response->getBody(), true);
            } else {
                // Check for 422 (validation) and then display below for general errors
                request()->session()->flash('status', $flash_status);
                return redirect()->action($redirectAction);
            }
        } catch (ClientException $e) {
            request()->session()->flash('status', 'api-error');
            request()->session()->flash('status-line', __LINE__);
            return redirect()->action($redirectAction);
        }

        return $content;
    }
}
