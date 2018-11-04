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
        return redirect()->action('IndexController@recent');
    }

    public function recent(Request $request)
    {
        /*$expenses = Api::public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->head(Config::get('web.config.api_uri_items') . '?limit=10');*/

        $expenses = Api::getInstance()
            ->public()
            ->redirectOnFailure('ErrorController@requestStatus')
            ->get(Config::get('web.config.api_uri_items') . '?limit=10');

        if ($expenses !== null) {
            return view(
                'recent',
                [
                    'display_navigation' => $this->display_navigation,
                    'display_add_expense' => $this->display_add_expense,
                    'nav_active' => $this->nav_active,
                    'resource_name' => Config::get('web.config.api_resource_name'),
                    'expenses' => $expenses,
                    'status' => $request->session()->get('status'),
                    'status_line' => $request->session()->get('status-line')
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
                '/' . $category_identifier . '/sub_categories'
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
