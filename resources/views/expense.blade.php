@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-12 col-md-8 mt-2 mt-lg-2">
        <h1 class="display-4">Expense</h1>

        <p class="lead">Expense details.</p>

        @if ($status !== null)
            @if ($status === 'category-not-assigned')
                <div class="alert alert-info" role="alert">
                    A category is not assigned to this expense.
                </div>
            @endif
            @if ($status === 'sub-category-not-assigned')
                <div class="alert alert-info" role="alert">
                    A sub category is not assigned to this expense.
                </div>
            @endif
            @if ($status === 'expense-not-deleted')
                <div class="alert alert-warning" role="alert">
                    Unable to add the expense, contact administrator!
                </div>
            @endif
        @endif

        <p><a href="{{ action('IndexController@recent') }}" class="btn btn-sm btn-outline-info">Return to recent</a></p>

        <dl class="row">
            <dt class="col-4">Description:</dt>
            <dd class="col-8">{{ $expense['description'] }}</dd>
            <dt class="col-4">Expense:</dt>
            <dd class="col-8">&pound;{{ $expense['total'] }}</dd>
            <dt class="col-4">Allocation:</dt>
            <dd class="col-8">{{ $expense['percentage'] }}%</dd>
            <dt class="col-4">Effective:</dt>
            <dd class="col-8">{{ date('jS F Y', strtotime($expense['effective_date'])) }}</dd>
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
    <div class="col-12 text-left">
        <p><a href="{{ action('ExpenseController@deleteExpense', ['expense_identifier' => $expense['id']]) }}" class="btn btn-sm btn-outline-danger">Delete expense</a></p>
    </div>
@endsection
