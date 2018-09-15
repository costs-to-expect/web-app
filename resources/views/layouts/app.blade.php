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
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-4 mt-4 mt-lg-4">
                    @yield('content')

                    <p class="mt-5 mb-3 text-muted text-center">&copy; Dean Blackborough 2018</p>
                </div>
            </div>
        </div>
        <script src="{{ asset('node_modules/jquery/dist/jquery.js') }}" defer></script>
        <script src="{{ asset('node_modules/popper.js/dist/umd/popper.js') }}" defer></script>
        <script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.js') }}" defer></script>
    </body>
</html>
