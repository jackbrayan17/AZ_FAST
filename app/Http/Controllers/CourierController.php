<?php
namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\User;
use App\Models\Address;
use App\Models\Role;
use App\Models\Client;
use App\Models\Order;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class CourierController extends Controller
{
    public function startDelivery($orderId)
    {
        $order = Order::findOrFail($orderId);
        $courier = auth()->user(); // Get the authenticated courier
        $order->status = 'In Transit';
        $order->save();
        // Create a new delivery record
        Delivery::create([
            'courier_id' => $courier->id,
            'client_id' => $order->client_id, // Assuming orders have a client_id
            'merchant_id' => $order->merchant_id,
            'order_id' => $order->id,
            'status' => 'Pending', // Set initial status to Pending
        ]);
    
        // Redirect to the tracking page or wherever needed
        return redirect()->route('courier.deliveries.start', $order->id)->with('success', 'Delivery started successfully!');
    }
    public function trackOrder(Request $request, $orderId)
    {
    
    $order = Order::findOrFail($orderId);
    $user = auth()->user();
    $courier = Courier::where('name', $user->name)->firstOrFail();
    $order->status = 'In Transit';
    // $courierLongitude = $request->input('longitude');
    // $courierLatitude = $request->input('latitude');
    // $courierAddressName = $request->input('address_name');

    // Save courier location data into the order
    $courierAddress = $courier->addresses()->latest()->first(); // Fetch the latest address
    $courierId = $courier->id;
    $order->courier_id = $courierId;
    $order->courier_longitude = $courierAddress->longitude;
    $order->courier_latitude = $courierAddress->latitude;
    $order->courier_address_name = $courierAddress->address_name;

    $order->save();
    $senderQuarter = $order->sender_quarter; 
    $receiverQuarter = $order->receiver_quarter;

    $senderAddress = Address::where('quarter', $senderQuarter)->firstOrFail();
    $receiverAddress = Address::where('quarter', $receiverQuarter)->firstOrFail();
   //$courierId = $courier->id; 
    $client = Client::findOrFail($order->client_id); // Assuming client_id is stored in the order
    $clientId = $client->id; 
    $merchantId = $order->merchant_id;

    // $delivery = new Delivery();
    // $delivery->courier_id = $courierId;
    // $delivery->client_id = $clientId;
    // $delivery->merchant_id = $merchantId;
    // $delivery->order_id = $order->id;
    // $delivery->status = 'Pending';
    // $delivery->save();
    // Delivery::create([
    //     'courier_id' => $courierId,
    //     'client_id' => $clientId, // Directly use client_id from the order
    //     'merchant_id' => $merchantId,
    //     'order_id' => $order->id,
    //     'status' => 'Pending', // Set initial status to Pending
    // ]);
    return view('courier.orders.track', [
        'senderLatitude' => $senderAddress->latitude,
        'senderLongitude' => $senderAddress->longitude,
        'receiverLatitude' => $receiverAddress->latitude,
        'receiverLongitude' => $receiverAddress->longitude,
        'courierLongitude' => $courierAddress->longitude,
        'courierLatitude' => $courierAddress->latitude,
        'courierAddressName' => $courierAddress->address_name,
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
