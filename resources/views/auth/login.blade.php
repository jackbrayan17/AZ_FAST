<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label>Email</label>
        <input type="email" name="email" required>
    
        <label>Mot de Passe</label>
        <input type="password" name="password" required>
    
        <button type="submit">Login</button>
    </form>
 </body>
</html>
