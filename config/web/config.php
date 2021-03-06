<?php

$key_api_resource_name = 'API_RESOURCE_NAME';
$key_api_resource_type_id = 'API_RESOURCE_TYPE_ID';
$key_api_resource_id = 'API_RESOURCE_ID';

$key_api_category_essentials = 'API_CATEGORY_ID_ESSENTIALS';
$key_api_category_non_essentials = 'API_CATEGORY_ID_NON_ESSENTIALS';
$key_api_category_hobbies = 'API_CATEGORY_ID_HOBBIES';

return [
    'api_base_url' => 'https://api.costs-to-expect.com/v2/',

    'api_uri_sign_in' => 'auth/login',
    'api_uri_categories' => 'resource-types/' . env($key_api_resource_type_id, null) . '/categories',
    'api_uri_resources' => 'resource-types/' .
        env($key_api_resource_type_id, null) . '/resources/',
    'api_uri_resource' => 'resource-types/' .
        env($key_api_resource_type_id, null) . '/resources/' .
        env($key_api_resource_id, null),
    'api_uri_items' => 'resource-types/' .
        env($key_api_resource_type_id, null) . '/resources/' .
        env($key_api_resource_id, null) . '/items',
    'api_uri_resource_summary' => 'summary/resource-types/' .
        env($key_api_resource_type_id, null) . '/resources/',
    'api_uri_categories_summary' => 'summary/resource-types/' .
        env($key_api_resource_type_id, null) . '/resources/' .
        env($key_api_resource_id, null) . '/items',
    'api_uri_categories_tco' => 'summary/resource-types/' .
        env($key_api_resource_type_id, null) . '/resources/' .
        env($key_api_resource_id, null) . '/items',
    'api_uri_years_summary' => 'summary/resource-types/' .
        env($key_api_resource_type_id, null) . '/resources/' .
        env($key_api_resource_id, null) . '/items',

    'api_resource_name' => env($key_api_resource_name, '[RESOURCE_NAME]'),

    'api_resource_type_id' => env($key_api_resource_type_id, null),
    'api_resource_id' => env($key_api_resource_id, null),

    'api_category_id_essentials' => env($key_api_category_essentials, null),
    'api_category_id_non_essentials' => env($key_api_category_non_essentials, null),
    'api_category_id_hobbies_and_interests' => env($key_api_category_hobbies, null),

    'version' => 'v1.04.8',
    'release_date' => '17th December 2019'
];
