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
     * @var string Controller and action to redirect to upon expected failure
     */
    private static $redirect_failure = null;

    /**
     * @var string Controller and action to redirect to upon exception
     */
    private static $redirect_exception = null;

    /**
     * @var Api
     */
    private static $instance;

    /**
     * Generate a new instance or return existing
     *
     * @return Api
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Set up a protected connection to the Costs to Expect API, return for
     * POST and DELETE
     *
     * @return Api
     */
    public static function protected(): Api
    {
        self::$redirect_failure = null;
        self::$redirect_exception = 'ErrorController@error-exception';

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
        self::$redirect_failure = null;
        self::$redirect_exception = 'ErrorController@error-exception';

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
     *
     * @return mixed
     */
    public static function get(string $uri): ?array
    {
        $content = null;

        try {
            $response = self::$client->get($uri);

            if ($response->getStatusCode() === 200) {
                $content = json_decode($response->getBody(), true);
            } else {
                if (self::$redirect_failure !== null) {
                    // Log error by posting to API
                    redirect()->action(self::$redirect_failure)->send();
                    exit;
                }
            }
        } catch (ClientException $e) {
            if (self::$redirect_exception !== null) {
                redirect()->action(self::$redirect_exception)->send();
                exit;
            }
        }

        return $content;
    }

    /**
     * Fetch pagination headers
     *
     * @param array $returned_headers Headers returned from HEAD request
     * @param array $params Params to fetch from headers
     * @param array $headers Headers array to populate
     */
    private static function fetchHeaderParams($returned_headers, $params, &$headers)
    {
        foreach ($params as $param) {
            if (
                array_key_exists($param, $returned_headers) &&
                array_key_exists(0, $returned_headers[$param])
            ) {
                $headers[$param] = $returned_headers[$param][0];
            }
        }
    }

    /**
     * Make a HEAD request to the API
     *
     * @param string $uri URI to make HEAD request to
     *
     * @return mixed
     */
    public static function head(string $uri): ?array
    {
        $headers = null;

        try {
            $response = self::$client->head($uri);

            if ($response->getStatusCode() === 200) {
                $returned_headers = $response->getHeaders();

                $headers = [];
                self::fetchHeaderParams(
                    $returned_headers,
                    [
                        'X-Total-Count',
                        'X-Count',
                        'X-Link-Previous',
                        'X-Link-Next'
                    ],
                    $headers
                );
            } else {
                if (self::$redirect_failure !== null) {
                    // Log error by posting to API
                    redirect()->action(self::$redirect_failure)->send();
                    exit;
                }
            }
        } catch (ClientException $e) {
            if (self::$redirect_exception !== null) {
                redirect()->action(self::$redirect_exception)->send();
                exit;
            }
        }

        return $headers;
    }

    /**
     * Make a POST request to the API
     *
     * @param string $uri URI to make POST request to
     * @param array $payload Payload to POST to the API
     * @param string $flash_error_status Status to store in flash session upon error
     *
     * @return mixed
     */
    public static function post(
        string $uri,
        array $payload,
        string $flash_error_status
    ): ?array {
        $content = null;

        try {
            $response = self::$client->post(
                $uri,
                [\GuzzleHttp\RequestOptions::JSON => $payload]
            );

            if ($response->getStatusCode() === 201) {
                $content = json_decode($response->getBody(), true);
            } else {

                // Switch to check for 422 (Validation error)

                if (self::$redirect_failure !== null) {
                    // Log error by posting to API
                    redirect()->action(self::$redirect_failure)->send();
                    exit;
                } else {
                    request()->session()->flash('status', $flash_error_status);
                    redirect()->action(self::$redirect_failure)->send();
                    exit;
                }
            }
        } catch (ClientException $e) {
            if (self::$redirect_exception !== null) {
                request()->session()->flash('status', 'api-error');
                request()->session()->flash('status-line', __LINE__);
                redirect()->action(self::$redirect_exception)->send();
                exit;
            }
        }

        return $content;
    }

    /**
     * Make a DELETE request to the API
     *
     * @param string $uri URI to make GET request to
     *
     * @return bool
     */
    public static function delete(string $uri): bool
    {
        $result = false;

        try {
            $response = self::$client->delete($uri);

            if ($response->getStatusCode() === 204) {
                $result = true;
            } else {
                if (self::$redirect_failure !== null) {
                    // Log error by posting to API
                    redirect()->action(self::$redirect_failure)->send();
                    exit;
                }
            }
        } catch (ClientException $e) {
            if (self::$redirect_exception !== null) {
                redirect()->action(self::$redirect_exception)->send();
                exit;
            }
        }

        return $result;
    }

    /**
     * Set the action to redirect upon expected failure
     *
     * @param string $redirectAction Redirect action for redirect()->action()
     *
     * @return Api
     */
    public static function redirectOnFailure(string $redirectAction): Api
    {
        self::$redirect_failure = $redirectAction;

        return new static();
    }

    /**
     * Set the action to redirect upon exception
     *
     * @param string $redirectAction Redirect action for redirect()->action()
     *
     * @return Api
     */
    public static function redirectOnException(string $redirectAction): Api
    {
        self::$redirect_exception = $redirectAction;

        return new static();
    }
}
