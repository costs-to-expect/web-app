@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-12 col-md-8 mt-2 mt-lg-2">
        <h1 class="h3 mb-2">Expenses for {{ $resource_name }}</h1>

        <p class="lead">The total sum of expenses in the following sub categories for {{ $resource_name }}.</p>

        <table class="table table-sm">
            <caption>Partial sub categories summary for {{ $resource_name }}.</caption>
            <thead>
                <tr class="bg-dark text-white">
                    <th scope="col">Sub category</th>
                    <th scope="col">Expenses total</th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sub_categories as $sub_category)
                <tr>
                    <td><strong>{{ $sub_category['name'] }}</strong></td>
                    <td>&pound;{{ $sub_category['total'] }}</td>
                    <td>&nbsp;</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
