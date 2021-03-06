@extends('layouts.app')

@section('content')
    <div class="col-12 col-sm-6 col-md-4 mt-2 mt-lg-2">
        <h1 class="display-4">Add expense</h1>

        <p class="lead">You can add a new expense for one of your children
            using the form below.</p>

        <form method="post" action="{{ action('ProcessController@processAddExpense') }}">
            <div class="form-group">
                <label for="resource_id">Child:</label>
                <select id="resource_id" name="resource_id" class="form-control form-control-sm" required>
                    @foreach ($children as $child)
                        <option value="{{ $child['id'] }}" @if ($child['id'] === $resource_id) selected="selected" @endif>{{ $child['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="item_description">Description:</label>
                <input type="text" id="item_description" name="description" class="form-control form-control-sm" placeholder="Expense description" required autofocus />
            </div>
            <div class="form-row">
                <div class="form-group col-6">
                    <label for="item_date">Effective date:</label>
                    <input type="date" id="item_date" name="effective_date" class="form-control form-control-sm" required />
                </div>
                <div class="form-group col-6">
                    <label for="item_total">Total: &pound;</label>
                    <input type="number" name="total" id="item_total" class="form-control form-control-sm" min="0.00" max="10000.00" step="0.01" placeholder="2.50" required />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-6">
                    <label for="item_allocation">Allocation: %</label>
                    <input type="number" name="allocation" id="item_allocation" class="form-control form-control-sm" min="0" max="100" step="1" placeholder="100" value="100" required />
                </div>
                <div class="form-group col-1">
                    &nbsp;
                </div>
                <div class="form-group col-5">
                    - <a href="#" class="set-allocation text-info" data-allocation="25">25%</a><br />
                    - <a href="#" class="set-allocation text-info" data-allocation="33">33%</a><br />
                    - <a href="#" class="set-allocation text-info" data-allocation="50">50%</a>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="item_date">Category:</label>
                </div>
                <div class="form-group col-12">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-info btn-sm active">
                            <input type="radio" name="options" class="category_selector" value="{{ $category_id_essentials }}" autocomplete="off" checked /> Essentials
                        </label>
                        <label class="btn btn-info btn-sm">
                            <input type="radio" name="options" class="category_selector" value="{{ $category_id_non_essentials }}" autocomplete="off" /> Non-Essentials
                        </label>
                        <label class="btn btn-info btn-sm">
                            <input type="radio" name="options" class="category_selector" value="{{ $category_id_hobbies_and_interests }}" autocomplete="off" /> Hobbies/Interests
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="item_sub_category_id">Subcategory:</label>
                <select id="item_sub_category_id" name="subcategory_id" class="form-control form-control-sm" required>
                    @foreach ($sub_categories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                {{ csrf_field() }}
                <input type="hidden" id="item_category_id" name="category_id" value="{{ $category_id_essentials }}" />
                <button class="btn btn-primary btn-block mt-3" type="submit">Save</button>
            </div>
        </form>
    </div>
@endsection
