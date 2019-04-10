<?php

namespace App\Http\Controllers;

use App\Request\Api;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;
use League\CommonMark\CommonMarkConverter;

class IndexController extends BaseController
{
    protected $display_navigation = true;
    protected $display_add_expense = true;
    protected $nav_active = 'recent';

    public function index(Request $request)
    {
        return redirect()->action('IndexController@recent', [ 'resource_id' => 'Eq9g6BgJL0']);
    }

    public function recent(Request $request, string $resource_id)
    {
        $expenses = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(Config::get('web.config.api_uri_resources') .
                $resource_id . '/items?limit=10');

        $resource = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(Config::get('web.config.api_uri_resources') .
                $resource_id);

        if ($expenses !== null) {
            return view(
                'recent',
                [
                    'display_navigation' => $this->display_navigation,
                    'display_add_expense' => $this->display_add_expense,
                    'nav_active' => $this->nav_active,
                    'expenses' => $expenses,
                    'status' => $request->session()->get('status'),
                    'status_line' => $request->session()->get('status-line'),
                    'resource' => $resource
                ]
            );
        }
    }

    public function subCategories(Request $request, string $category_identifier)
    {
        $sub_categories = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(
                Config::get('web.config.api_uri_categories') .
                '/' . $category_identifier . '/subcategories'
            );

        return response()->json($sub_categories, 200);
    }

    public function versionHistory()
    {
        $converter = new CommonMarkConverter();
        $html = $converter->convertToHtml(file_get_contents('../CHANGELOG.md'));

        return view(
            'version-history',
            [
                'display_navigation' => $this->display_navigation,
                'display_add_expense' => $this->display_add_expense,
                'nav_active' => 'version-history',
                'version_history' => $html
            ]
        );
    }
}
