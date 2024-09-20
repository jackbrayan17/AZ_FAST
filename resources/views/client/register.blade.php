<form method="POST" action="{{ route('client.register') }}">
    @csrf
    <label>Nom Complet</label>
    <input type="text" name="name" required>
    
    <label>Email</label>
    <input type="email" name="email" required>
    
    <label>Numéro de Téléphone</label>
    <input type="text" name="phone" required>
    
    <label>Mot de Passe</label>
    <input type="password" name="password" required>
    
    <label>Confirmation Mot de Passe</label>
    <input type="password" name="password_confirmation" required>
    
    <button type="submit">S'inscrire</button>
</form>
