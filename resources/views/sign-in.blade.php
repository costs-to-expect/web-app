@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3">Costs to Expect - {{ $resource }}</h1>

    <p class="lead">Sign in below to start adding expenses for {{ $resource }}.</p>

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
@endsection
