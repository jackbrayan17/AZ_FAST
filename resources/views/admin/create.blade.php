@extends('layout.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">Créer un Administrateur</h2>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.register') }}">
        @csrf
        <label for="name" class="block mb-2">Nom Complet</label>
        <input id="name" type="text" name="name" required class="input-field" placeholder="Entrez le nom complet" autofocus>

        <label for="email" class="block mb-2">Email</label>
        <input id="email" type="email" name="email" required class="input-field" placeholder="Entrez l'email">

        <label for="phone" class="block mb-2">Numéro de Téléphone</label>
        <input id="phone" type="text" name="phone" required class="input-field" placeholder="Entrez le numéro de téléphone">

        <label for="password" class="block mb-2">Mot de Passe</label>
        <input id="password" type="password" name="password" required class="input-field" placeholder="Entrez le mot de passe">

        <label for="password_confirmation" class="block mb-2">Confirmer le Mot de Passe</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required class="input-field" placeholder="Confirmer le mot de passe">

        <button type="submit" class="btn-primary">Créer Administrateur</button>
    </form>
</div>
@endsection
