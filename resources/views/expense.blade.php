@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-12 col-md-8 mt-2 mt-lg-2">
        <h1 class="h3 mb-2">Expense</h1>

        <p class="lead">Expense details.</p>

        <p><a href="{{ action('IndexController@recent') }}" class="btn btn-sm btn-outline-info">Return to recent</a></p>

        <dl class="row">
            <dt class="col-3">Description</dt>
            <dd class="col-9">{{ $expense['description'] }}</dd>
            <dt class="col-3">Effective date</dt>
            <dd class="col-9">{{ $expense['effective_date'] }}</dd>
            <dt class="col-3">>Total</dt>
            <dd class="col-9">{{ $expense['actualised_total'] }}</dd>
        </dl>
    </div>
@endsection
