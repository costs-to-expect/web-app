@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-12 col-md-8 mt-2 mt-lg-2">
        <h1 class="h3 mb-2">Expenses for {{ $resource_name }}</h1>

        <p class="lead">To date, the total sum of expenses for
            {{ $resource_name }} is &pound;{{ $tco['total'] }}.</p>
    </div>
@endsection
