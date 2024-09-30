@extends('layout.admin')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
   
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Admin Dashboard</h2>
    
    <div class="flex flex-col md:flex-row gap-4 mb-4">
        <a href="{{ route('admin.couriers.create') }}" class="w-full md:w-auto bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            Add Courier
        </a>

        <a href="{{ route('admin.storekeepers.create') }}" class="w-full md:w-auto bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
            Add Storekeeper
        </a>
    </div>

    <!-- Manage Users -->
    <div class="mt-8">
        <h3 class="text-xl font-semibold mb-4">Manage Users</h3>

        <div class="overflow-x-auto">
            <table class="table-auto w-full text-left">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6">#</th>
                        <th class="py-3 px-6">Name</th>
                        <th class="py-3 px-6">Role</th>
                        <th class="py-3 px-6">Email</th>
                        <th class="py-3 px-6">Phone</th>
                        <th class="py-3 px-6">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($users as $user)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $loop->iteration }}</td>
                        <td class="py-3 px-6">{{ $user->name }}</td>
                        <td class="py-3 px-6">{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                        <td class="py-3 px-6">{{ $user->email }}</td>
                        <td class="py-3 px-6">{{ $user->phone }}</td>
                        <td class="py-3 px-6">
                            <div class="flex item-center space-x-4">
                                <a href="{{ route('admin.couriers.edit', $user->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('admin.couriers.delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
