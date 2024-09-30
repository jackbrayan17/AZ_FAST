@extends('layout.app')

@section('content')
<div class="container mx-auto">
    @if (auth()->check())
        <h1 class="text-3xl font-bold mb-4">Bienvenue, {{ auth()->user()->name }}!</h1>
        <p class="mb-4">Vous êtes connecté à votre tableau de bord.</p>

        <!-- Button to upgrade to Merchant Client -->
        <form method="GET" action="{{ route('client.upgrade.form') }}" class="inline">
            <button type="submit" class="btn-secondary">Devenir Merchant Client</button>
        </form>
    @else
        <h1 class="text-3xl font-bold mb-4">Bienvenue, invité!</h1>
        <p class="mb-4">Veuillez vous connecter pour accéder à votre tableau de bord.</p>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold">Vos Commandes</h2>
            <p>Manage Orders.</p>
            <a href="{{ route('client.orders') }}" class="text-blue-500">Voir les Commandes</a>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold">Profil</h2>
            <p>Manage Profile.</p>
            <a href="{{ route('client.profile') }}" class="text-blue-500">Voir le Profil</a>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold">Support</h2>
            <p>Contact & Support.</p>
            <a href="{{ route('client.support') }}" class="text-blue-500">Contacter le Support</a>
        </div>
    </div>
</div>
@endsection
