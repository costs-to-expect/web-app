@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-12 col-md-8 mt-2 mt-lg-2">
        <h1>Oops! <small>Exception</small></h1>

        <p class="lead">There was an error with the application, the error has
            been logged*, please try again.

        <p>If you continue to experience the issue please contact
            the administrator.</p>

        <p><small>* This is a lie until I make a small change to the API.</small></p>
    </div>
@endsection
