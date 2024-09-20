@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">Gestion des Utilisateurs</h2>
    <table class="min-w-full">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>
                        <!-- Add edit/delete buttons here -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
