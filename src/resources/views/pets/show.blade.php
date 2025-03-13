@extends('app')

@section('content')
<div class="container">
    <h1>Pet Details</h1>
    <p><strong>ID:</strong> {{ $pet['id'] }}</p>
    <p><strong>Name:</strong> {{ $pet['name'] }}</p>
    <p><strong>Status:</strong> {{ $pet['status'] }}</p>
    <a href="{{ route('pets.index') }}" class="btn btn-primary">Back to List</a>
</div>
@endsection