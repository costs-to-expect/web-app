<?php

namespace App\Http\Controllers;

use App\Request\Api;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;

class SummaryController extends BaseController
{
    protected $display_navigation = true;
    protected $display_add_expense = true;
    protected $nav_active = 'recent';

    public function monthsSummary(Request $request, string $resource_id, string $year_identifier)
    {
        $months = null;
        $this->nav_active = 'summaries';

        $months = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(
                Config::get('web.config.api_uri_years_summary') .
                '?year=' . $year_identifier . '&months=true'
            );

        if ($months !== null) {
            return view(
                'months-summary',
                [
                    'display_navigation' => $this->display_navigation,
                    'display_add_expense' => $this->display_add_expense,
                    'nav_active' => $this->nav_active,
                    'months' => $months,
                    'year' => $year_identifier
                ]
            );
        }
    }

    public function summaries(Request $request, string $resource_id)
    {
        $categories = null;
        $years = null;
        $this->nav_active = 'summaries';

        $resource = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(Config::get('web.config.api_uri_resources') .
                $resource_id);

        $categories = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(
                Config::get('web.config.api_uri_resource_summary') .
                $resource_id . '/items?categories=true'
            );

        $years = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(
                Config::get('web.config.api_uri_resource_summary') .
                $resource_id . '/items?years=true'
            );

        if ($categories !== null && $years !== null) {
            return view(
                'summaries',
                [
                    'display_navigation' => $this->display_navigation,
                    'display_add_expense' => $this->display_add_expense,
                    'nav_active' => $this->nav_active,
                    'categories' => $categories,
                    'years' => $years,
                    'resource' => $resource
                ]
            );
        }
    }

    public function subCategoriesSummary(Request $request, string $resource_id, string $category_identifier)
    {
        $category = null;
        $sub_categories = null;
        $this->nav_active = 'summaries';

        $category = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(
                Config::get('web.config.api_uri_category') . '/' .
                $category_identifier
            );

        $sub_categories = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(
                Config::get('web.config.api_uri_categories_summary') .
                '?category=' . $category_identifier . '&subcategories=true'
            );

        if ($category === null || $sub_categories !== null) {
            return view(
                'sub-categories-summary',
                [
                    'display_navigation' => $this->display_navigation,
                    'display_add_expense' => $this->display_add_expense,
                    'nav_active' => $this->nav_active,
                    'category' => $category,
                    'sub_categories' => $sub_categories
                ]
            );
        }
    }

    public function categoriesTco(Request $request, string $resource_id)
    {
        $tco = null;
        $this->nav_active = 'tco-summary';

        $resource = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(Config::get('web.config.api_uri_resources') .
                $resource_id);

        $tco = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(
                Config::get('web.config.api_uri_resource_summary') .
                $resource_id . '/items'
            );

        if ($tco !== null) {
            return view(
                'tco-summary',
                [
                    'display_navigation' => $this->display_navigation,
                    'display_add_expense' => $this->display_add_expense,
                    'nav_active' => $this->nav_active,
                    'tco' => $tco,
                    'resource' => $resource
                ]
            );
        }
    }
}
