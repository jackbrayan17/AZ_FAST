@extends('layout.app')

@section('content')

<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">Mon Profil</h2>
    
    <form method="POST" action="{{ route('client.profile.update') }}">
        @csrf
        @method('PUT')
        
        <label class="block mb-2">Nom Complet</label>
        <input type="text" name="name" value="{{ auth()->user()->name }}" required class="input-field">

        <label class="block mb-2">Email</label>
        <input type="email" name="email" value="{{ auth()->user()->email }}" required class="input-field">

        <label class="block mb-2">Numéro de Téléphone</label>
        <input type="text" name="phone" value="{{ auth()->user()->phone }}" required class="input-field">

        <button type="submit" class="btn-primary">Mettre à Jour</button>
    </form>
</div>

@endsection
