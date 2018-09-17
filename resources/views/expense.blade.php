@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-12 col-md-8 mt-2 mt-lg-2">
        <h1 class="h3 mb-2">Expense</h1>

        <p class="lead">Expense details.</p>

        <p><a href="{{ action('IndexController@recent') }}" class="btn btn-sm btn-outline-info">Return to recent</a></p>

        <dl class="row">
            <dt class="col-4">Description:</dt>
            <dd class="col-8">{{ $expense['description'] }}</dd>
            <dt class="col-4">Expense:</dt>
            <dd class="col-8">&pound;{{ $expense['total'] }}</dd>
            <dt class="col-4">Allocation:</dt>
            <dd class="col-8">{{ $expense['percentage'] }}%</dd>
            <dt class="col-4">Effective:</dt>
            <dd class="col-8">{{ date('dS F Y', strtotime($expense['effective_date'])) }}</dd>
            <dt class="col-4">Total:</dt>
            <dd class="col-8">&pound;{{ $expense['actualised_total'] }}</dd>
        </dl>
    </div>
@endsection
