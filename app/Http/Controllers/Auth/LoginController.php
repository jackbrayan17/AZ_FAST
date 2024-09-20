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
            \Log::info('User logged in: ', ['email' => $user->email, 'role' => $user->role->name]);
            // Redirect based on user roles
            switch ($user->role->name) {
                case 'Super Admin':
                    return redirect()->route('superadmin.dashboard');
                case 'Admin':
                    return redirect()->route('admin.dashboard');
                case 'Storekeeper':
                    return redirect()->route('storekeeper.dashboard');
                case 'Courier':
                    return redirect()->route('courier.dashboard');
                case 'Client':
                    return redirect()->route('client.dashboard');
                default:
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
