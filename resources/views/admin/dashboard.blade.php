@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">Tableau de Bord Administrateur</h2>
    <a href="{{ route('admin.create.form') }}" class="btn-primary">Créer un Administrateur</a>
    <a href="{{ route('users.index') }}" class="btn-primary">Gérer les Utilisateurs</a>
    <!-- Add more admin functionalities here -->
</div>
@endsection
