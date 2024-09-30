<?php
namespace App\Http\Controllers;

use App\Models\Storekeeper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StorekeeperController extends Controller
{
    // List all storekeepers
    public function index()
    {
        $storekeepers = Storekeeper::all();
        return view('storekeepers.index', compact('storekeepers'));
    }

    // Show form to create a new storekeeper
    public function create()
    {
        return view('storekeepers.create');
    }

    // Store new storekeeper
    public function store(Request $request)
    {
        $request->validate([
            'id_number' => 'required|string|max:50|unique:storekeepers,id_number',
            'availability' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
        ]);

        Storekeeper::create([
            'user_id' => Auth::id(),
            'id_number' => $request->id_number,
            'availability' => $request->availability,
            'city' => $request->city,
            'neighborhood' => $request->neighborhood,
        ]);

        return redirect()->route('storekeepers.index')->with('success', 'Storekeeper created successfully.');
    }

    // Edit a storekeeper
    public function edit(Storekeeper $storekeeper)
    {
        return view('storekeepers.edit', compact('storekeeper'));
    }

    // Update a storekeeper
    public function update(Request $request, Storekeeper $storekeeper)
    {
        $request->validate([
            'id_number' => 'required|string|max:50|unique:storekeepers,id_number,'.$storekeeper->id,
            'availability' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
        ]);

        $storekeeper->update($request->all());

        return redirect()->route('storekeepers.index')->with('success', 'Storekeeper updated successfully.');
    }

    // Delete a storekeeper
    public function destroy(Storekeeper $storekeeper)
    {
        $storekeeper->delete();
        return redirect()->route('storekeepers.index')->with('success', 'Storekeeper deleted successfully.');
    }
}
