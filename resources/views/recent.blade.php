@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-12 col-md-8 mt-4 mt-lg-4">
        <h1 class="h3 mb-3">{{ $resource_name }}'s recent expenses</h1>

        <table class="table">
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
