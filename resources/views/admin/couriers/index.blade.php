@extends('layout.admin')

@section('content')
<div class="container">
    <h1>Manage Couriers</h1>
    <a href="{{ route('admin.couriers.create') }}" class="btn btn-primary">Add New Courier</a>

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
            @foreach($couriers as $courier)
            <tr>
                <td>{{ $courier->id }}</td>
                <td>{{ $courier->user->name }}</td>
                <td>{{ $courier->user->email }}</td>
                <td>{{ $courier->user->phone }}</td>
                <td>{{ $courier->id_number }}</td>
                <td>
                    <a href="{{ route('admin.couriers.edit', $courier->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.couriers.destroy', $courier->id) }}" method="POST" style="display:inline;">
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
