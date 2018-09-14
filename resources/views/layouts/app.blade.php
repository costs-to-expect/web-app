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
                <div class="col-4 mt-lg-5">
                    @yield('content')

                    <h1 class="h3 mb-3">Costs to Expect - Expenses</h1>

                    <p class="lead">Sign in below to start adding expenses for a resource.</p>

                    <form>
                        <div class="form-group">
                            <label for="inputEmail">Email address:</label>
                            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">Password:</label>
                            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>

                            <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">Sign in</button>
                        </div>
                    </form>

                    <p class="mt-5 mb-3 text-muted text-center">&copy; Dean Blackborough 2018</p>
                </div>
            </div>
        </div>
        <script src="{{ asset('node_modules/jquery/dist/jquery.js') }}" defer></script>
        <script src="{{ asset('node_modules/popper.js/dist/umd/popper.js') }}" defer></script>
        <script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.js') }}" defer></script>
    </body>
</html>
