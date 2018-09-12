<!doctype html>
    <html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Costs to Expect</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
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

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>
