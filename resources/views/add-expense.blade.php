@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-6 col-md-4 mt-2 mt-lg-2">
        <h1 class="h3 mb-2">Add expense</h1>

        <p class="lead">You can add a new expense for {{ $resource_name }} using
            the form below.</p>

        <form method="post" action="{{ action('IndexController@processAddExpense') }}">
            <div class="form-group">
                <label for="item_description">Description:</label>
                <input type="text" id="item_description" name="description" class="form-control" placeholder="Expense description" required autofocus />
            </div>
            <div class="form-group">
                <label for="item_date">Effective date:</label>
                <input type="date" id="item_date" name="effective_date" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="item_total">Total:</label>
                <input type="number" name="total" id="item_total" class="form-control" min="0.00" max="10000.00" step="0.01" placeholder="2.50" required />
            </div>
            <div class="form-group">
                <label for="item_date">Category:</label>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary btn-sm active">
                        <input type="radio" name="options" class="category_selector" value="{{ $category_id_essentials }}" autocomplete="off" checked /> Essentials
                    </label>
                    <label class="btn btn-secondary btn-sm">
                        <input type="radio" name="options" class="category_selector" value="{{ $category_id_non_essentials }}" autocomplete="off" /> Non-Essentials
                    </label>
                    <label class="btn btn-secondary btn-sm">
                        <input type="radio" name="options" class="category_selector" value="{{ $category_id_hobbies_and_interests }}" autocomplete="off" /> Hobbies and Interests
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="item_sub_category_id">Sub category:</label>
                <select id="item_sub_category_id" name="sub_category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                {{ csrf_field() }}
                <input type="hidden" id="item_category_id" name="category_id" value="{{ $category_id_essentials }}" />
                <button class="btn btn-sm btn-primary btn-block mt-3" type="submit">Save</button>
            </div>
        </form>
    </div>
@endsection
