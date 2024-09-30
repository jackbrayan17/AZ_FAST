<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Log the user details for debugging
        \Log::info('User logged in: ', ['user' => $user]);

        // Check roles for redirection
        if ($user->hasRole('Super Admin')) {
            return redirect()->route('superadmin.dashboard');
        } elseif ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('Storekeeper')) {
            return redirect()->route('storekeeper.dashboard');
        } elseif ($user->hasRole('Courier')) {
            return redirect()->route('courier.dashboard');
        } elseif ($user->hasRole('Client')) {
            return redirect()->route('client.dashboard');
        } else {
            return redirect()->route('login');
        }
    }

    return redirect()->back()->withErrors(['error' => 'Invalid credentials']);
}


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
