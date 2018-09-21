@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-12 col-md-8 mt-2 mt-lg-2">
        <h1 class="h3 mb-2">Summaries</h1>

        <p class="lead">The total sum of expenses in the {{ $category['name'] }}
            category for {{ $resource_name }}.</p>

        <dl class="row">
            <dt class="col-3">{{ $category['name'] }}</dt>
            <dd class="col-9">{{ $category['description'] }}</dd>
        </dl>

        <p><a href="{{ action('IndexController@summaries') }}" class="btn btn-sm btn-outline-info">Return to summary</a></p>

        <table class="table table-sm">
            <caption>Expenses summed by {{ $category['name'] }} category.</caption>
            <thead>
                <tr class="bg-dark text-white">
                    <th scope="col">Category</th>
                    <th scope="col">Total</th>
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
