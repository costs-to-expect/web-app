@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-12 col-md-8 mt-2 mt-lg-2">
        <h1 class="h3 mb-2">Recent expenses</h1>

        <p class="lead">The last 5 expenses that have been entered for {{ $resource_name }}.</p>

        <table class="table table-sm">
            <caption>Recent expenses added for {{ $resource_name }}</caption>
            <thead>
                <tr class="bg-dark text-white d-none d-sm-table-row">
                    <th scope="col">Description</th>
                    <th scope="col">When</th>
                    <th scope="col">Expense</th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr class="d-table-row d-sm-none">
                    <td colspan="4"><strong>{{ $item['description'] }}</strong></td>
                </tr>
                <tr class="d-table-row d-sm-none">
                    <td colspan="2">{{ date('dS F Y', strtotime($item['effective_date'])) }}</td>
                    <td>&pound;{{ $item['actualised_total'] }}</td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="d-none d-sm-table-row">
                    <td><strong>{{ $item['description'] }}</strong></td>
                    <td>{{ date('dS M', strtotime($item['effective_date'])) }}</td>
                    <td>&pound;{{ $item['actualised_total'] }}</td>
                    <td>&nbsp;</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
