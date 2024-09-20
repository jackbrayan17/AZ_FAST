@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">Créer un Administrateur</h2>
    <form method="POST" action="{{ route('admin.create') }}">
        @csrf
        <label class="block mb-2">Nom Complet</label>
        <input type="text" name="name" required class="input-field" placeholder="Entrez le nom complet">

        <label class="block mb-2">Email</label>
        <input type="email" name="email" required class="input-field" placeholder="Entrez l'email">

        <label class="block mb-2">Numéro de Téléphone</label>
        <input type="text" name="phone" required class="input-field" placeholder="Entrez le numéro de téléphone">

        <label class="block mb-2">Mot de Passe</label>
        <input type="password" name="password" required class="input-field" placeholder="Entrez le mot de passe">

        <button type="submit" class="btn-primary">Créer Administrateur</button>
    </form>
</div>
@endsection
