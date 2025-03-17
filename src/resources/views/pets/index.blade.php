@extends('app')

<style>
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            margin: 0 5px;
            padding: 5px 10px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #007bff;
            border-radius: 3px;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }

        .pagination a.active {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border: 1px solid #007bff;
        }
    </style>

@section('content')
<div class="container">
    <h1>All Pets</h1>

    <!-- Formularz wyboru statusu -->
    <form method="GET" action="{{ route('pets.index') }}" class="mb-3">
        <label for="status">Filter by Status:</label>
        <select name="status" id="status" onchange="this.form.submit()">
            <option value="available" {{ $status == 'available' ? 'selected' : '' }}>Available</option>
            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="sold" {{ $status == 'sold' ? 'selected' : '' }}>Sold</option>
        </select>
    </form>

    <!-- Sortowanie -->
    <form method="GET" action="{{ route('pets.index') }}" class="mb-3">
        <input type="hidden" name="status" value="{{ $status }}">
        <label for="sort_by">Sort by:</label>
        <select name="sort_by" id="sort_by" onchange="this.form.submit()">
            <option value="id" {{ $sortBy == 'id' ? 'selected' : '' }}>ID</option>
            <option value="name" {{ $sortBy == 'name' ? 'selected' : '' }}>Name</option>
        </select>

        <label for="sort_order">Order:</label>
        <select name="sort_order" id="sort_order" onchange="this.form.submit()">
            <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Ascending</option>
            <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Descending</option>
        </select>
    </form>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Błędy walidacji -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="{{ route('pets.create') }}" class="btn btn-primary">Add New Pet</a>

    <table class="table">
        <thead>
            <tr>
                <th><a href="{{ route('pets.index', ['status' => $status, 'sort_by' => 'id', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">ID</a></th>
                <th><a href="{{ route('pets.index', ['status' => $status, 'sort_by' => 'name', 'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc']) }}">Name</a></th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paginatedPets as $pet)
            <tr>
                <td>{{ $pet['id'] ?? 'No ID' }}</td>
                <td>{{ $pet['name'] ?? 'No name' }}</td>
                <td>{{ $pet['status'] ?? 'No status' }}</td>
                <td>
                    <a href="{{ route('pets.show', $pet['id']) }}" class="btn btn-info">View</a>
                    <a href="{{ route('pets.edit', $pet['id']) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginacja -->
    <div class="pagination">
        <!-- Previous Button -->
        @if ($currentPage > 1)
            <a href="{{ route('pets.index', ['status' => $status, 'sort_by' => $sortBy, 'sort_order' => $sortOrder, 'page' => $currentPage - 1]) }}">Previous</a>
        @endif

        <!-- Numery stron -->
        @for ($page = 1; $page <= $totalPages; $page++)
            <a href="{{ route('pets.index', ['status' => $status, 'sort_by' => $sortBy, 'sort_order' => $sortOrder, 'page' => $page]) }}" class="{{ $currentPage == $page ? 'active' : '' }}">{{ $page }}</a>
        @endfor

        <!-- Next Button -->
        @if ($currentPage < $totalPages)
            <a href="{{ route('pets.index', ['status' => $status, 'sort_by' => $sortBy, 'sort_order' => $sortOrder, 'page' => $currentPage + 1]) }}">Next</a>
        @endif
    </div>
</div>
@endsection

