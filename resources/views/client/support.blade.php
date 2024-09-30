@extends('layout.app')

@section('content')

<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">Support Client</h2>
    
    <form method="POST" action="{{ route('client.support.submit') }}">
        @csrf
        
        <label class="block mb-2">Sujet</label>
        <input type="text" name="subject" required class="input-field" placeholder="Entrez le sujet">

        <label class="block mb-2">Message</label>
        <textarea name="message" required class="input-field" rows="4" placeholder="Entrez votre message"></textarea>

        <button type="submit" class="btn-primary">Envoyer</button>
    </form>
</div>

@endsection
