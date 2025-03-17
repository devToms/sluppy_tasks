@extends('app')

@section('content')
<form action="{{ route('pets.update', $pet['id']) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Pet Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $pet['name'] }}" required>
    </div>

    <div class="form-group">
        <label for="category_name">Category Name</label>
        <input type="text" class="form-control" id="category_name" name="category[name]" value="{{ $pet['category']['name'] }}" required>
    </div>

    <div class="form-group">
        <label for="photoUrls">Photo URLs</label>
        @foreach ($pet['photoUrls'] as $index => $url)
            <input type="text" class="form-control" id="photoUrls" name="photoUrls[]" value="{{ $url }}" required>
        @endforeach
    </div>

    <div class="form-group">
        <label for="tags">Tags</label>
        @foreach ($pet['tags'] as $index => $tag)
            <input type="text" class="form-control" id="tags" name="tags[{{ $index }}][name]" value="{{ $tag['name'] }}" required>
        @endforeach
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select class="form-control" id="status" name="status" required>
            <option value="available" {{ $pet['status'] === 'available' ? 'selected' : '' }}>available</option>
            <option value="pending" {{ $pet['status'] === 'pending' ? 'selected' : '' }}>pending</option>
            <option value="sold" {{ $pet['status'] === 'sold' ? 'selected' : '' }}>sold</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update Pet</button>
</form>
@endsection