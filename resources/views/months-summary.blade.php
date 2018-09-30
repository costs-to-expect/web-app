@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-12 col-md-8 mt-2 mt-lg-2">
        <h1 class="display-4">Summaries</h1>

        <p class="lead">The total sum of expenses in {{ $year }}
            for {{ $resource_name }}.</p>

        <p><a href="{{ action('IndexController@summaries') }}" class="btn btn-sm btn-outline-info">Return to summaries</a></p>

        <table class="table table-sm">
            <caption>Expenses summed by {{ $year }} month.</caption>
            <thead>
                <tr class="bg-dark text-white">
                    <th scope="col">Month</th>
                    <th scope="col">Total</th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($months as $month)
                <tr>
                    <td><strong>{{ $month['month'] }}</strong></td>
                    <td>&pound;{{ $month['total'] }}</td>
                    <td><a href="{{ action('IndexController@expenses', ['year' => $year, 'month' => $month['id']]) }}" class="text-info">**</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
