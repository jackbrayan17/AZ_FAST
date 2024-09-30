@extends('layout.admin')

@section('content')
<div class="container">
    <h1>Manage Storekeepers</h1>
    <a href="{{ route('admin.storekeepers.create') }}" class="btn btn-primary">Add New Storekeeper</a>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>ID Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($storekeepers as $storekeeper)
            <tr>
                <td>{{ $storekeeper->id }}</td>
                <td>{{ $storekeeper->user->name }}</td>
                <td>{{ $storekeeper->user->email }}</td>
                <td>{{ $storekeeper->user->phone }}</td>
                <td>{{ $storekeeper->id_number }}</td>
                <td>
                    <a href="{{ route('admin.storekeepers.edit', $storekeeper->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.storekeepers.destroy', $storekeeper->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
