@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-12 col-md-8 mt-2 mt-lg-2">
        <h1 class="display-4">Total</h1>

        <p class="lead">To date, the total sum of expenses for
            <strong>{{ $resource['name'] }}</strong> are <strong>&pound;{{ $tco['total'] }}</strong>,
            Oh my god!</p>
    </div>
@endsection
