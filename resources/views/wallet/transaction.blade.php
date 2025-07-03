@extends('layout.app')

@section('content')
<header class="flex items-center justify-between bg-gray-100 p-4 rounded-lg shadow mb-6">
    <!-- AZ Logo on the Left -->
    <div class="flex items-center">
        <a href="/client/dashboard"> 
            <img src="{{ asset('AZ_fastlogo.png') }}" alt="Logo" class="h-10 w-auto mr-4">
        </a>   </div>

    <!-- User Info and Logout on the Right -->
    <div class="flex items-center ml-auto">
        <!-- Display Profile Picture -->
        @if (auth()->user()->profileImage)
            <img src="{{ asset('storage/' . auth()->user()->profileImage->image_path) }}" alt="Profile Image" class="w-10 h-10 rounded-full">
        @else
            <img src="{{ asset('jblogo.png') }}" alt="Default Profile Image" class="w-10 h-10 rounded-full">
            <a href="{{ route('profile.edit') }}" class="text-blue-500 ml-2">Add profile</a>
        @endif

        <div class="ml-2">
            <h1 class="text-3xl font-bold">{{ auth()->user()->name }}!</h1>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="ml-4">
            @csrf
            <button type="submit" class="text-red-500 hover:text-red-700">Déconnexion</button>
        </form>
    </div>
</header>
<div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6">Votre portefeuille</h1>

    <p class="mb-4 text-lg">Solde actuel: <span class="font-semibold">{{ number_format($wallet->balance, 2) }} FCFA</span></p>

    <!-- Deposit Form -->
    <form action="{{ route('wallet.deposit') }}" method="POST" class="mb-8 p-4 bg-gray-100 rounded-lg shadow">
        @csrf
        <h2 class="text-xl font-semibold mb-4">Déposer des fonds</h2>

        <label for="transaction_type" class="block mb-2 font-medium">Choisir le type de transaction:</label>
        <select name="transaction_type" class="form-select mb-4 block w-full border border-gray-300 rounded-md p-2" required>
            <option value="MTN">MTN MoMo</option>
            <option value="Orange">Orange Money</option>
        </select>

        <label for="phone_number" class="block mb-2 font-medium">Numéro de téléphone (MTN ou Orange):</label>
        <input type="text" name="phone_number" class="form-input mb-4 block w-full border border-gray-300 rounded-md p-2" required placeholder="Numéro de transaction">

        <label for="amount" class="block mb-2 font-medium">Montant à déposer:</label>
        <input type="number" name="amount" step="0.01" class="form-input mb-4 block w-full border border-gray-300 rounded-md p-2" required>

        <button type="submit" class="w-full bg-green-500 text-white font-semibold py-2 rounded-md hover:bg-green-600 transition duration-300">Déposer</button>
    </form>

    <!-- Withdraw Form -->
    <form action="{{ route('wallet.withdraw') }}" method="POST" class="p-4 bg-gray-100 rounded-lg shadow">
        @csrf
        <h2 class="text-xl font-semibold mb-4">Retirer des fonds</h2>

        <label for="transaction_type" class="block mb-2 font-medium">Choisir le type de transaction:</label>
        <select name="transaction_type" class="form-select mb-4 block w-full border border-gray-300 rounded-md p-2" required>
            <option value="MTN">MTN MoMo</option>
            <option value="Orange">Orange Money</option>
        </select>

        <label for="phone_number" class="block mb-2 font-medium">Numéro de téléphone (MTN ou Orange):</label>
        <input type="text" name="phone_number" class="form-input mb-4 block w-full border border-gray-300 rounded-md p-2" required placeholder="Numéro de transaction">

        <label for="amount" class="block mb-2 font-medium">Montant à retirer:</label>
        <input type="number" name="amount" step="0.01" class="form-input mb-4 block w-full border border-gray-300 rounded-md p-2" required>

        <button type="submit" class="w-full bg-red-500 text-white font-semibold py-2 rounded-md hover:bg-red-600 transition duration-300">Retirer</button>
    </form>

    <!-- Display Messages -->
    @if(session('success'))
        <p class="mt-4 text-green-500 font-semibold">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p class="mt-4 text-red-500 font-semibold">{{ session('error') }}</p>
    @endif
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --gray-light: #e9ecef;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f7ff;
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .logo {
        height: 70px;
        transition: var(--transition);
    }

    .logo:hover {
        transform: scale(1.05);
    }


        .main-header {
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 3px 0;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

        /* Header Styles */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2);
            margin-bottom: 50px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .header::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
        }

        .logo img {
            height: 40px;
            transition: transform 0.3s ease;
        }

        .logo:hover img {
            transform: scale(1.05);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile-pic {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-pic:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .user-name {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .logout-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            margin-left: 15px;
        }

        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        .add-profile-link {
            color: white;
            font-size: 0.8rem;
            margin-left: 5px;
            text-decoration: underline;
        }

        /* Main Content */
        .wallet-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 30px;
            margin-bottom: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .wallet-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .wallet-title {
            font-size: 2rem;
            margin-bottom: 20px;
            color: var(--dark);
            position: relative;
            display: inline-block;
        }

        .wallet-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary);
            border-radius: 3px;
        }

        .balance {
            font-size: 1.5rem;
            margin-bottom: 30px;
            padding: 15px;
            background: linear-gradient(135deg, #f5f7ff 0%, #e8ecff 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .balance-amount {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.8rem;
        }

        /* Transaction Forms */
        .transaction-form {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border: 1px solid var(--gray-light);
            transition: all 0.3s ease;
        }

        .transaction-form:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border-color: rgba(67, 97, 238, 0.2);
        }

        .form-title {
            font-size: 1.3rem;
            margin-bottom: 20px;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-title i {
            color: var(--primary);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }

        select, input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--gray-light);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        select:focus, input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .deposit-btn {
            background: linear-gradient(135deg, var(--success) 0%, #3a86ff 100%);
            color: white;
        }

        .deposit-btn:hover {
            background: linear-gradient(135deg, #3a86ff 0%, var(--success) 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(58, 134, 255, 0.4);
        }

        .withdraw-btn {
            background: linear-gradient(135deg, var(--danger) 0%, #ff6d00 100%);
            color: white;
        }

        .withdraw-btn:hover {
            background: linear-gradient(135deg, #ff6d00 0%, var(--danger) 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(247, 37, 133, 0.4);
        }

        /* Messages */
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
            animation: fadeIn 0.5s ease;
        }

        .alert-success {
            background-color: rgba(76, 201, 240, 0.1);
            color: #00a8cc;
            border-left: 4px solid #00a8cc;
        }

        .alert-error {
            background-color: rgba(247, 37, 133, 0.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .user-info {
                flex-direction: column;
            }

            .logout-btn {
                margin-left: 0;
                margin-top: 10px;
            }

            .wallet-title {
                font-size: 1.5rem;
            }

            .balance {
                font-size: 1.2rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .balance-amount {
                font-size: 1.5rem;
            }
        }

        /* Floating Elements */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        @media (max-width: 768px) {

        .header-container {
            padding: 0 15px;
        }

        .user-menu {
            gap: 10px;
        }
    }
    </style>
</div>
@endsection
