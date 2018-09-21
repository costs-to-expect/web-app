@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-12 col-md-8 mt-2 mt-lg-2">
        <h1 class="display-4">Summaries</h1>

        <h3>Categories</h3>

        <p class="lead">Categories summary for {{ $resource_name }}, select a
            category to see the sub category break down.</p>

        <table class="table table-sm table-hover">
            <caption>Expenses summed by category.</caption>
            <thead>
                <tr class="bg-dark text-white">
                    <th scope="col">Category</th>
                    <th scope="col">Total</th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td><strong><a href="{{ action('IndexController@subCategoriesSummary', ['category_identifier' => $category['id']]) }}" class="text-info">{{ $category['name'] }}</a></strong></td>
                    <td>&pound;{{ $category['total'] }}</td>
                    <td>&nbsp;</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Years</h3>

        <p class="lead">Years summary for {{ $resource_name }}, select a
            year to see the monthly break down.</p>

        <table class="table table-sm table-hover">
            <caption>Expenses summed by year.</caption>
            <thead>
            <tr class="bg-dark text-white">
                <th scope="col">Year</th>
                <th scope="col">Total</th>
                <th scope="col">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($years as $year)
                <tr>
                    <td><strong><a href="{{ action('IndexController@subCategoriesSummary', ['category_identifier' => $year['id']]) }}" class="text-info">{{ $year['year'] }}</a></strong></td>
                    <td>&pound;{{ $year['total'] }}</td>
                    <td>&nbsp;</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
