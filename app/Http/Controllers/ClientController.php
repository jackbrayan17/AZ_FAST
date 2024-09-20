<?php
// ClientController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Hash;

class ClientController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create a new client
        // $client = new User();
        // $client->name = $request->name;
        // $client->email = $request->email;
        // $client->phone = $request->phone;
        // $client->password = Hash::make($request->password);
        // $client->role_id = Role::where('name', 'client')->first()->id; // Set role to 'client'
        // $client->save();

        // return redirect()->back()->with('success', 'Client registered successfully!');
        $client = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => Role::where('name', 'Client')->first()->id,
        ]);

        return redirect()->route('client.dashboard')->with('success', 'Client account created successfully');
  

    }
}
