@extends('layout.app')

@section('content')

<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-4">Tableau de Bord du Merchant</h1>
    <p>Bienvenue, {{ auth()->user()->name }}! </p>
    <!-- Add more content relevant to the merchant dashboard here -->
</div>

@endsection
