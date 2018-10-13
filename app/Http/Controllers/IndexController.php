<?php

namespace App\Http\Controllers;

use App\Request\Api;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;
use League\CommonMark\CommonMarkConverter;

class IndexController extends BaseController
{
    protected $display_nav_options = true;
    protected $nav_active = 'recent';

    public function index(Request $request)
    {
        return redirect()->action('IndexController@recent');
    }

    public function recent(Request $request)
    {
        $expenses = Api::public()->get(
            Config::get('web.config.api_uri_items') . '?limit=5',
            'IndexController@index'
        );

        if ($expenses !== null) {
            return view(
                'recent',
                [
                    'display_nav_options' => $this->display_nav_options,
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
        $sub_categories = Api::public()->get(
            Config::get('web.config.api_uri_categories') .
            '/' . $category_identifier . '/sub_categories',
            'IndexController@index'
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
                'display_nav_options' => $this->display_nav_options,
                'nav_active' => 'version-history',
                'version_history' => $html
            ]
        );
    }
}
