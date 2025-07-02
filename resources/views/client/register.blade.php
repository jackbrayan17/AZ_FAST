<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('AZ_fastlogo.png') }}" type="image/png">
    <title>Client Registration</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>
    <div class="register-card">
        <!-- Card Header -->
        <div class="card-header">
            <img src="{{ asset('AZ_fastlogo.png') }}" alt="Logo">
            <h1 class="card-title">S'inscrire</h1>
        </div>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('client.register') }}">
            @csrf

            <!-- Name Field -->
            <div class="form-group">
                <label for="name">Nom Complet</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <!-- Email Field -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <!-- Phone Field -->
            <div class="form-group">
                <label for="phone">Numéro de Téléphone</label>
                <input type="text" name="phone" id="phone" class="form-control" required>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password">Mot de Passe</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <!-- Confirm Password Field -->
            <div class="form-group">
                <label for="password_confirmation">Confirmation Mot de Passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn">S'inscrire</button>
        </form>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="error-container">
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Log In Link -->
        <p class="login-link">
            Log In: <a href="{{ route('login') }}">Log In</a>
        </p>
    </div>
</body>

</html>