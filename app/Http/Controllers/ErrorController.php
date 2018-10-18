<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ErrorController extends BaseController
{
    protected $display_navigation = true;
    protected $display_add_expense = false;
    protected $nav_active = 'recent';

    public function requestStatus(Request $request)
    {
        return view(
            'error-request-status',
            [
                'display_navigation' => $this->display_navigation,
                'display_add_expense' => $this->display_add_expense,
                'nav_active' => $this->nav_active
            ]
        );
    }

    public function exception(Request $request)
    {
        return view(
            'error-exception',
            [
                'display_navigation' => $this->display_navigation,
                'display_add_expense' => $this->display_add_expense,
                'nav_active' => $this->nav_active
            ]
        );
    }
}
