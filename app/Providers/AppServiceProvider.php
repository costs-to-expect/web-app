<?php

namespace App\Providers;

use App\Request\Api;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View()->composer('layouts.app', function($view) {
            $view->with(
                'version',
                [
                    'number' => Config::get('web.config.version'),
                    'date' => Config::get('web.config.release_date'),
                ]
            );
            $view->with(
                'children',
                Api::getInstance()
                    ->public()
                    ->redirectOnFailure('ErrorController@requestStatus')
                    ->get(Config::get('web.config.api_uri_resources'))
            );
            $view->with(
                'selected_resource_id',
                request()->session()->get('selected_resource_id')
            );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
