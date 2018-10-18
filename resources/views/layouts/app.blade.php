<!doctype html>
    <html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Costs to Expect</title>

        <link href="{{ asset('node_modules/bootstrap/dist/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon-32x32.png') }}" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="{{ action('IndexController@recent') }}">Costs-to-Expect.com</a>
            @if ($display_navigation === true)
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item @if ($nav_active === 'add-expense') active @endif">
                        <a class="nav-link" href="{{ action('ExpenseController@addExpense') }}">Add expense</a>
                    </li>
                    <li class="nav-item @if ($nav_active === 'recent') active @endif">
                        <a class="nav-link" href="{{ action('IndexController@recent') }}">Recent expenses</a>
                    </li>
                    <li class="nav-item @if ($nav_active === 'tco-summary') active @endif">
                        <a class="nav-link" href="{{ action('SummaryController@categoriesTco') }}">Total expenses</a>
                    </li>
                    <li class="nav-item @if ($nav_active === 'summaries') active @endif">
                        <a class="nav-link" href="{{ action('SummaryController@summaries') }}">Summaries</a>
                    </li>
                    <li class="nav-item @if ($nav_active === 'version-history') active @endif">
                        <a class="nav-link" href="{{ action('IndexController@versionHistory') }}">Version history</a>
                    </li>
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
            @if ($display_add_expense === true && $nav_active !== 'add-expense')
                <div class="col-12 text-right mt-2">
                    <p><a href="{{ action('ExpenseController@addExpense') }}" class="btn btn-sm btn-outline-success">Add new expense</a></p>
                </div>
            @endif
            <p class="mt-5 mb-3 text-muted text-center">
                Copyright &copy; <a href="https://www.deanblackborough.com">Dean Blackborough</a> {{ date('Y') }}<br />
                <small><a href="{{ action('IndexController@versionHistory') }}">{{ $version["number"] . ' - ' .  $version["date"] }}</a></small>
            </p>
        </div>
        <script src="{{ asset('node_modules/jquery/dist/jquery.js') }}" defer></script>
        <script src="{{ asset('node_modules/popper.js/dist/umd/popper.js') }}" defer></script>
        <script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.js') }}" defer></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>
