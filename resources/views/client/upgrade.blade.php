@extends('layout.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">Devenir Merchant Client</h2>
    <p>Vous serez facturé 1000 FCFA pour devenir un Merchant Client.</p>

    <form method="POST" action="{{ route('client.upgrade') }}">
        @csrf

        <label>Choisissez votre méthode de paiement:</label><br>
        <input type="radio" name="payment_method" value="Orange Money" required> Orange Money<br>
        <input type="radio" name="payment_method" value="MTN Momo" required> MTN Momo<br>

        <label>Numéro de téléphone:</label>
        <input type="text" name="phone" required>

        <button type="submit" class="btn-primary">Confirmer le Paiement</button>
    </form>
</div>
@endsection
