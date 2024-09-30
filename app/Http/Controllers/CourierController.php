<?php
namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourierController extends Controller
{
    // List all couriers
    public function index()
    {
        
        $couriers = Courier::with('user')->get();
        return view('admin.couriers.index', compact('couriers'));
    }

    public function create()
    {
        // Show form to create a new courier
        return view('admin.couriers.create');
    }

    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:15|unique:users,phone',
            'password' => 'required|string|min:4|confirmed',
            'id_number' => 'required|string|max:50|unique:couriers,id_number',
            'vehicle_brand' => 'required|string|max:255',
            'vehicle_registration_number' => 'required|string|max:255|unique:couriers,vehicle_registration_number',
            'vehicle_color' => 'required|string|max:255',
            'availability' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
        ]);

        // Create the user
        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
            ]);

            // Assign the Courier role
            $role = Role::firstOrCreate(['name' => 'Courier', 'guard_name' => 'web']);
            DB::table('model_has_roles')->insert([
                'role_id' => $role->id,
                'model_id' => $user->id,
                'model_type' => 'App\Models\User',
            ]);

            // Create the courier entry
            Courier::create([
                'user_id' => $user->id,
                'id_number' => $request->id_number,
                'vehicle_brand' => $request->vehicle_brand,
                'vehicle_registration_number' => $request->vehicle_registration_number,
                'vehicle_color' => $request->vehicle_color,
                'availability' => $request->availability,
                'city' => $request->city,
                'neighborhood' => $request->neighborhood,
            ]);

            return $user;
        });

        // Send email with credentials
        Mail::to($user->email)->send(new UserCredentialsMail($user, $request->password));

        return redirect()->route('admin.couriers.index')->with('success', 'Courier created successfully');
    }
    // Edit a courier
    public function edit(Courier $courier)
    {
        return view('couriers.edit', compact('courier'));
    }

    // Update a courier
    public function update(Request $request, Courier $courier)
    {
        $request->validate([
            'vehicle_brand' => 'required|string|max:255',
            'vehicle_registration_number' => 'required|string|max:255|unique:couriers,vehicle_registration_number,'.$courier->id,
            'vehicle_color' => 'required|string|max:255',
            'availability' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
        ]);

        $courier->update($request->all());

        return redirect()->route('couriers.index')->with('success', 'Courier updated successfully.');
    }

    // Delete a courier
    public function destroy(Courier $courier)
    {
        $courier->delete();
        return redirect()->route('couriers.index')->with('success', 'Courier deleted successfully.');
    }
}
