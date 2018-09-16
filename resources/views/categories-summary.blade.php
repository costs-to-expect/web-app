@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-12 col-md-8 mt-2 mt-lg-2">
        <h1 class="h3 mb-2">Expenses for {{ $resource_name }}</h1>

        <p class="lead">The total sum of each expense category for {{ $resource_name }}.</p>

        <table class="table table-sm table-hover">
            <caption>Categories summary for {{ $resource_name }}, select a
                category to see the sub category break down.</caption>
            <thead>
                <tr class="bg-dark text-white">
                    <th scope="col">Category</th>
                    <th scope="col">Expenses total</th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td><strong><a href="{{ action('IndexController@subCategoriesSummary', ['category_identifier' => $category['id']]) }}">{{ $category['name'] }}</a></strong></td>
                    <td>&pound;{{ $category['total'] }}</td>
                    <td>&nbsp;</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
