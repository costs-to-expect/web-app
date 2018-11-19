@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-12 col-md-8 mt-2 mt-lg-2">
        <h1>Oops! <small>Unexpected response from API</small></h1>

        <p class="lead">The API returned an unexpected status code, the request
            that caused this error and the returned status code have been logged,
            please try again.

        <p class="lead">If you continue to experience the issue please contact the
            developer, or log an issue on <a href="https://github.com/costs-to-expect/web-app/issues">GitHub</a>.</p>
    </div>
@endsection
