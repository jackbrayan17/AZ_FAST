<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Adjust the model name if needed

class OrderController extends Controller
{
    // Display the client's orders
    public function index()
    {
        $orders = Order::where('client_id', auth()->id())->get(); // Fetch orders for the logged-in client
        return view('client.orders.index', compact('orders'));
    }

    // Show the details of a specific order
    public function show($id)
    {
        $order = Order::findOrFail($id); // Fetch the order by ID
        return view('client.orders.show', compact('order'));
    }
}
