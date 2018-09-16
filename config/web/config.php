<?php

$key_api_resource_name = 'API_RESOURCE_NAME';
$key_api_resource_type_id = 'API_RESOURCE_TYPE_ID';
$key_api_resource_id = 'API_RESOURCE_ID';

return [
    'api_resource_name' => env($key_api_resource_name, '[RESOURCE_NAME]'),
    'api_base_url' => 'https://api.costs-to-expect.com/v1/',
    'api_uri_sign_in' => 'auth/login',
    'api_uri_resource' => 'resource_types/' .
        env($key_api_resource_type_id, null) . '/resources/' .
        env($key_api_resource_id, null),
    'api_uri_recent' => 'resource_types/' .
        env($key_api_resource_type_id, null) . '/resources/' .
        env($key_api_resource_id, null) . '/items/',

    'api_resource_type_id' => env($key_api_resource_type_id, null),
    'api_resource_id' => env($key_api_resource_id, null),
];