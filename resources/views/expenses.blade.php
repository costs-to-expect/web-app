@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-12 col-md-8 mt-2 mt-lg-2">
        <h1 class="display-4">Expenses</h1>

        @if ($limit !== 50)
            <p class="lead">All {{ $limit }} expenses that have been entered
                for the selected child in {{ $filtering }}</p>
        @else
            <p class="lead">The last {{ $limit }} expenses that have been entered
                for the selected child, in {{ $filtering }}</p>
        @endif

        <p><a href="{{ action('SummaryController@summaries') }}" class="btn btn-sm btn-outline-info">Return to summaries</a></p>

        <table class="table table-sm">
            <caption>Filtered recent expenses added for the listed child</caption>
            <thead>
                <tr class="bg-dark text-white d-none d-sm-table-row">
                    <th scope="col">Expense</th>
                    <th scope="col">When</th>
                    <th scope="col">Total</th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $expense)
                <tr class="d-table-row d-sm-none">
                    <td colspan="4"><strong><a href="{{ action('ExpenseController@expense', ['expense_identifier' => $expense['id']]) }}" class="text-info">{{ $expense['name'] }}</a></strong></td>
                </tr>
                <tr class="d-table-row d-sm-none">
                    <td colspan="2">{{ date('jS F Y', strtotime($expense['effective_date'])) }}</td>
                    <td>&pound;{{ $expense['actualised_total'] }}</td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="d-none d-sm-table-row">
                    <td><strong><a href="{{ action('ExpenseController@expense', ['expense_identifier' => $expense['id']]) }}" class="text-info">{{ $expense['name'] }}</a></strong></td>
                    <td>{{ date('jS M', strtotime($expense['effective_date'])) }}</td>
                    <td>&pound;{{ $expense['actualised_total'] }}</td>
                    <td>&nbsp;</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
