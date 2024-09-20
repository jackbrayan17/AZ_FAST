<?php
// AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Hash;

class AdminController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => Role::where('name', 'Admin')->first()->id,
        ]);
        // Create a new admin
        // $admin = new User();
        // $admin->name = $request->name;
        // $admin->email = $request->email;
        // $admin->phone = $request->phone;
        // $admin->password = Hash::make($request->password);
        // $admin->role_id = Role::where('name', 'admin')->first()->id; // Set role to 'admin'
        // $admin->save();

        return redirect()->route('admin.dashboard')->with('success', 'Admin created successfully');
        }
}
