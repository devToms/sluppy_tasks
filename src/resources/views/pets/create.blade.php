@extends('app')

@section('content')
<div class="container">
    <h1>Add New Pet</h1>
    <form action="{{ route('pets.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Pet Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <!-- Category -->
        <div class="form-group">
            <label for="category_name">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category[name]" required>
        </div>

        <!-- Photo URLs -->
        <div class="form-group">
            <label for="photoUrls">Photo URLs (comma separated)</label>
            <input type="text" class="form-control" id="photoUrls" name="photoUrls" required>
            <small class="form-text text-muted">Enter photo URLs separated by commas.</small>
        </div>

        <!-- Tags -->
        <div class="form-group">
            <label for="tags">Tags (comma separated)</label>
            <input type="text" class="form-control" id="tags" name="tags" required>
            <small class="form-text text-muted">Enter tag names separated by commas.</small>
        </div>

        <!-- Status -->
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="available">available</option>
                <option value="pending">pending</option>
                <option value="sold">sold</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Pet</button>
    </form>
</div>
@endsection
