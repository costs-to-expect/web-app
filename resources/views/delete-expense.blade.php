@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-12 col-md-8 mt-2 mt-lg-2">
        <h1 class="h3 mb-2">Delete</h1>

        <p class="lead">Are you sure you want to delete this expense?</p>

        <p><a href="{{ action('IndexController@expense', ['expense_identifier' => $expense['id']]) }}" class="btn btn-sm btn-outline-info">Return to expense</a></p>

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

            @if ($category !== null)
                <dt class="col-4">Category:</dt>
                <dd class="col-8">{{ $category['category']['name'] }}</dd>
                <dt class="col-4">Description:</dt>
                <dd class="col-8"><p>{{ $category['category']['description'] }}</p></dd>
            @endif

            @if ($sub_category !== null)
                <dt class="col-4">Sub category:</dt>
                <dd class="col-8">{{ $sub_category['sub_category']['name'] }}</dd>
                <dt class="col-4">Description:</dt>
                <dd class="col-8"><p>{{ $sub_category['sub_category']['description'] }}</p></dd>
            @endif
        </dl>
    </div>
    <div class="col-12 text-left mt-2">
        <form method="post" action="{{ action('IndexController@processDeleteExpense') }}">
            <div class="form-group">
                {{ csrf_field() }}
                <input type="hidden" name="expense_identifier_id" value="{{ $expense_identifier_id }}" />
                <input type="hidden" name="expense_category_identifier_id" value="{{ $expense_category_identifier_id }}" />
                <input type="hidden" name="expense_sub_category_identifier_id" value="{{ $expense_sub_category_identifier_id }}" />
                <button class="btn btn-sm btn-danger" type="submit">Confirm delete expense</button>
            </div>
        </form>
    </div>
@endsection
