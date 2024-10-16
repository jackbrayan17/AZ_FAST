<?php
namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\User;
use App\Models\Address;
use App\Models\Role;
use App\Models\Order;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class CourierController extends Controller
{
    public function trackOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        $senderQuarter = $order->sender_quarter; 
        $receiverQuarter = $order->receiver_quarter;
        $senderAddress = Address::where('quarter', $senderQuarter)->firstOrFail();
        $receiverAddress = Address::where('quarter', $receiverQuarter)->firstOrFail();
        $user = request()->user();
        $courierId = $user ? $user->id : null; 
        $clientId = $order->client_id; 
        $merchantId = $order->merchant_id;
        $delivery = new Delivery();
        $delivery->courier_id = $courierId;
        $delivery->client_id = $clientId;
        $delivery->merchant_id = $merchantId;
        $delivery->order_id = $order->id;
        $delivery->status = 'pending';
        // $delivery->save();

        return view('courier.orders.track', [
            'senderLatitude' => $senderAddress->latitude,
            'senderLongitude' => $senderAddress->longitude,
            'receiverLatitude' => $receiverAddress->latitude,
            'receiverLongitude' => $receiverAddress->longitude,
            //'courierId' => $courier->id,
        
        ]);
    }
    public function updateLocation(Request $request)
    {
        $request->validate([
            'courier_id' => 'required|exists:couriers,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        CourierLocation::create([
            'courier_id' => $request->courier_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
    
        return response()->json(['message' => 'Location updated successfully.']);
    }
    public function index()
    { 
        $couriers = Courier::with('user')->get();
        return view('admin.couriers.index', compact('couriers'));
    }
    public function dashboard(){
        $courier = auth()->user();
        $pendingOrders = Order::where('status', 'Pending')->get(['id', 'sender_quarter', 'receiver_quarter' ,'sender_town', 'receiver_town','product_info','sender_name', 'receiver_name']);
        $deliveredOrders = Order::where('status', 'Delivered')->get(['id', 'sender_quarter', 'receiver_quarter','sender_town', 'receiver_town','product_info', 'sender_name', 'receiver_name']);
        $TransitOrders = Order::where('status', 'In Transit')->get(['id', 'sender_quarter', 'receiver_quarter','sender_town', 'receiver_town','product_info', 'sender_name', 'receiver_name']);

        // Pass both variables to the view
        return view('courier.dashboard', compact('TransitOrders','pendingOrders', 'deliveredOrders'));
    }
    public function create()
    {
        // Show form to create a new courier
        return view('admin.couriers.create');
    }
    public function getLocation($id)
    {
        $courier = Courier::findOrFail($id);
    
        return response()->json([
            'latitude' => $courier->latitude,
            'longitude' => $courier->longitude,
        ]);
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
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'courier',  // Setting the role as 'merchant'
        ]);
       $courier = Courier::create([
            'user_id' => $user->id,
            'id_number' => $request->id_number,
            'name' => $request->name,
            'availability' => $request->availability,   
            'vehicle_registration_number' => $request->vehicle_registration_number,
            'vehicle_color' => $request->vehicle_color,
            'vehicle_brand' => $request->vehicle_brand,
            'city' => $request->city,
            'neighborhood' => $request->neighborhood,
        ]);
        $user->wallet()->create([
            'balance' => 0.00,  // Initial balance
        ]);
        $roleId = Role::where('name', 'Courier')->first()->id;

        // Insert manually into the model_has_roles table
        DB::table('model_has_roles')->insert([
            'role_id' => $roleId,                // The ID of the 'Merchant' role
            'model_id' => $user->id,             // The ID of the user
            'model_type' => 'App\Models\User',   // The model type (usually 'App\Models\User')
        ]);
        return redirect()->route('admin.couriers.index')->with('success', 'Courier saved successfully.');
       }
    // Edit a courier
    public function edit(Courier $courier)
    {
        return view('courier.edit', compact('courier'));
    }

    // Update a courier
    public function update(Request $request, Courier $courier)
    {
        $request->validate([
            'id_number' => 'required|string|max:50|unique:couriers,id_number',
            'vehicle_brand' => 'required|string|max:255',
            'vehicle_registration_number' => 'required|string|max:255|unique:couriers,vehicle_registration_number,'.$courier->id,
            'vehicle_color' => 'required|string|max:255',
            'availability' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
        ]);

        $courier->update($request->all());

        return redirect()->route('admin.couriers.index')->with('success', 'Courier updated successfully.');
    }

    // Delete a courier
    public function destroy(Courier $courier)
    {
        $courier->delete();
        return redirect()->route('admin.couriers.index')->with('success', 'Courier deleted successfully.');
    }
}
