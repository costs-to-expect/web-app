@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-12 col-md-8 mt-2 mt-lg-2">
        <h1 class="display-4">Recent</h1>

        <p class="lead">The last 10 expenses that have been entered for the selected child.</p>

        @if ($status !== null)
            @if ($status === 'expense-added')
                <div class="alert alert-success" role="alert">
                    Your expense has been added, it should be in the list below.
                </div>
            @endif
            @if ($status === 'expense-not-added')
                <div class="alert alert-danger" role="alert">
                    Unable to add the expense, contact administrator!
                </div>
            @endif
            @if ($status === 'api-error')
                <div class="alert alert-danger" role="alert">
                    Encountered a problem contacting the API, contact the administrator with error code: {{ $status_line }}!
                </div>
            @endif
            @if ($status === 'expense-not-added-item')
                <div class="alert alert-warning" role="alert">
                    Unable to add the expense item, try again and contact administrator if it fails.
                </div>
            @endif
            @if ($status === 'expense-not-added-item-category')
                <div class="alert alert-info" role="alert">
                    Unable to add the category for the new expense, assign via edit.
                </div>
            @endif
            @if ($status === 'expense-not-added-item-sub-category')
                <div class="alert alert-info" role="alert">
                    Unable to add the sub category for the new expense, assign via edit.
                </div>
            @endif
            @if ($status === 'expense-deleted')
                <div class="alert alert-success" role="alert">
                    The expense has been deleted.
                </div>
            @endif
        @endif

        <table class="table table-sm">
            <caption>Recent expenses added for the selected child</caption>
            <thead>
                <tr class="bg-dark text-white d-none d-sm-table-row">
                    <th scope="col">Description</th>
                    <th scope="col">When</th>
                    <th scope="col">Expense</th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $expense)
                <tr class="d-table-row d-sm-none">
                    <td colspan="4"><strong><a href="{{ action('ExpenseController@expense', ['expense_identifier' => $expense['id']]) }}" class="text-info">{{ $expense['description'] }}</a></strong></td>
                </tr>
                <tr class="d-table-row d-sm-none">
                    <td colspan="2">{{ date('jS F Y', strtotime($expense['effective_date'])) }}</td>
                    <td>&pound;{{ $expense['actualised_total'] }}</td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="d-none d-sm-table-row">
                    <td><strong><a href="{{ action('ExpenseController@expense', ['expense_identifier' => $expense['id']]) }}" class="text-info">{{ $expense['description'] }}</a></strong></td>
                    <td>{{ date('jS M', strtotime($expense['effective_date'])) }}</td>
                    <td>&pound;{{ $expense['actualised_total'] }}</td>
                    <td>&nbsp;</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
