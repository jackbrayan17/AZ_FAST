<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ClientController extends Controller
{
    public function showUpgradeForm()
{
    return view('client.upgrade');
}

    public function upgradeToMerchant(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'phone' => 'required|string|max:15',
        ]);
    
        // Simulate payment processing
        // In a real application, you'd interact with a payment API here.
        
        // Assuming the payment is successful, proceed to upgrade the client
        $client = auth()->user();
    
        // Upgrade the client to Merchant Client using DB facade
        DB::table('model_has_roles')->insert([
            'role_id' => DB::table('roles')->where('name', 'Merchant Client')->value('id'),
            'model_id' => $client->id,
            'model_type' => 'App\Models\User',
        ]);
    
        return redirect()->route('merchant.dashboard')->with('success', 'Vous êtes maintenant un Merchant Client!');
    }
    // Display the client registration form
    public function showRegisterForm()
    {
        return view('client.register'); // Assuming the form view is in 'resources/views/client/register.blade.php'
    }

    // Handle client registration
    public function register(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:4|confirmed',
        ]);

        // Create the client (user) record
        $client = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
        ]);

        // Fetch the Client role
        $role = Role::where('name', 'Client')->first();

        // Assign the 'Client' role using DB facade
        DB::table('model_has_roles')->insert([
            'role_id' => $role->id,
            'model_id' => $client->id,
            'model_type' => 'App\Models\User',  // Explicitly specify the model type
        ]);

        // Redirect to a success page or client dashboard
        return redirect()->route('client.dashboard')->with('success', 'Client registered successfully');
    }

    // Display the client dashboard after registration (optional)
    public function dashboard()
    {
        $users = User::with('roles')->get();
        return view('client.dashboard', compact('users')); // Assuming you have a 'client/dashboard.blade.php' view
    }
}
