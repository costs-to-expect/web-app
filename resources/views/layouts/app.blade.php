<!doctype html>
    <html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Costs to Expect</title>

        <link href="{{ asset('node_modules/bootstrap/dist/css/bootstrap.css') }}" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="{{ action('IndexController@recent') }}">Costs to Expect</a>
            @if ($display_nav_options) === true)
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ action('IndexController@recent') }}">Recent expenses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ action('IndexController@categoriesTco') }}">Total expenses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ action('IndexController@categoriesSummary') }}">Sum per category</a>
                    </li>
                    {{--<li class="nav-item">
                        <a class="nav-link" href="#">Categories</a>
                    </li>--}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ action('AuthenticationController@signOut') }}">Sign out</a>
                    </li>
                </ul>
            </div>
            @endif
        </nav>
        <div class="container-fluid">
            <div class="row justify-content-center">
                @yield('content')
            </div>
        </div>
        <div class="container">
            <p class="mt-5 mb-3 text-muted text-center">&copy; Dean Blackborough 2018</p>
        </div>
        <script src="{{ asset('node_modules/jquery/dist/jquery.js') }}" defer></script>
        <script src="{{ asset('node_modules/popper.js/dist/umd/popper.js') }}" defer></script>
        <script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.js') }}" defer></script>
    </body>
</html>
