<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ErrorController extends BaseController
{
    protected $display_nav_options = true;
    protected $nav_active = 'recent';

    public function requestStatus(Request $request)
    {
        return view(
            'error-request-status',
            [
                'display_nav_options' => $this->display_nav_options,
                'nav_active' => $this->nav_active
            ]
        );
    }

    public function exception(Request $request)
    {
        return view(
            'error-exception',
            [
                'display_nav_options' => $this->display_nav_options,
                'nav_active' => $this->nav_active
            ]
        );
    }
}
