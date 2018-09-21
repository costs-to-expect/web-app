@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-6 col-md-4 mt-2 mt-lg-2">
        <h1 class="display-4">Sign in</h1>

        <p class="lead">Sign in below to start adding expenses for {{ $resource_name }}.</p>

        <form method="post" action="{{ action('AuthenticationController@processSignIn') }}">
            <div class="form-group">
                <label for="sign_in_email">Email address:</label>
                <input type="email" id="sign_in_email" name="email" class="form-control" placeholder="Email address" required autofocus>
            </div>
            <div class="form-group">
                <label for="sign_in_password">Password:</label>
                <input type="password" id="sign_in_password" name="password" class="form-control" placeholder="Password" required>
                {{ csrf_field() }}
                <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">Sign in</button>
            </div>
        </form>
    </div>
@endsection
