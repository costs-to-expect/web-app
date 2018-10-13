<?php

namespace App\Http\Controllers;

use App\Request\Api;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;
use League\CommonMark\CommonMarkConverter;

class SummaryController extends BaseController
{
    protected $display_nav_options = true;
    protected $nav_active = 'recent';

    public function monthsSummary(Request $request, string $year_identifier)
    {
        $months = null;
        $this->nav_active = 'summaries';

        $months = Api::public()->get(
            Config::get('web.config.api_uri_years_summary') .
            '/' . $year_identifier . '/months',
            'IndexController@index'
        );

        if ($months !== null) {
            return view(
                'months-summary',
                [
                    'display_nav_options' => $this->display_nav_options,
                    'nav_active' => $this->nav_active,
                    'resource_name' => Config::get('web.config.api_resource_name'),
                    'months' => $months,
                    'year' => $year_identifier
                ]
            );
        }
    }

    public function summaries(Request $request)
    {
        $categories = null;
        $years = null;
        $this->nav_active = 'summaries';

        $categories = Api::public()->get(
            Config::get('web.config.api_uri_categories_summary'),
            'IndexController@index'
        );

        $years = Api::public()->get(
            Config::get('web.config.api_uri_years_summary'),
            'IndexController@index'
        );

        if ($categories !== null && $years !== null) {
            return view(
                'summaries',
                [
                    'display_nav_options' => $this->display_nav_options,
                    'nav_active' => $this->nav_active,
                    'resource_name' => Config::get('web.config.api_resource_name'),
                    'categories' => $categories,
                    'years' => $years
                ]
            );
        }
    }

    public function subCategoriesSummary(Request $request, string $category_identifier)
    {
        $category = null;
        $sub_categories = null;
        $this->nav_active = 'summaries';

        $category = Api::public()->get(
            Config::get('web.config.api_uri_category') . '/' .
            $category_identifier,
            'IndexController@index'
        );

        $sub_categories = Api::public()->get(
            Config::get('web.config.api_uri_categories_summary') .
            '/' . $category_identifier . '/sub_categories',
            'IndexController@index'
        );

        if ($category === null || $sub_categories !== null) {
            return view(
                'sub-categories-summary',
                [
                    'display_nav_options' => $this->display_nav_options,
                    'nav_active' => $this->nav_active,
                    'resource_name' => Config::get('web.config.api_resource_name'),
                    'category' => $category,
                    'sub_categories' => $sub_categories
                ]
            );
        }
    }

    public function categoriesTco(Request $request)
    {
        $tco = null;
        $this->nav_active = 'tco-summary';

        $tco = Api::public()->get(
            Config::get('web.config.api_uri_categories_tco'),
            'IndexController@index'
        );

        if ($tco !== null) {
            return view(
                'tco-summary',
                [
                    'display_nav_options' => $this->display_nav_options,
                    'nav_active' => $this->nav_active,
                    'resource_name' => Config::get('web.config.api_resource_name'),
                    'tco' => $tco
                ]
            );
        }
    }
}
