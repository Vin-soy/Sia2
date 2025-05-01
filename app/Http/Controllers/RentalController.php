<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    public function index() {
        return view('admin.listings.index');
    }

    public function create() {
        return view('landlord.layouts.account');
    }
    public function store(Request $request)
    {
        $request->validate([
            'landlord_id' => 'required|exists:users,id',
            'address' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'number_of_rooms' => 'required|integer',
            'home_type' => 'required|string',
            'status' => 'required|in:available,rented,under_maintenance',
        ]);
    
        // For testing - see what's coming in
        // dd($request->all());
    
        $rental = new House(); // or Rental or Property - depending on your model
        $rental->landlord_id = $request->landlord_id;
        $rental->address = $request->address;
        $rental->description = $request->description;
        $rental->price = $request->price;
        $rental->number_of_rooms = $request->number_of_rooms;
        $rental->house_type = $request->home_type;
        $rental->status = $request->status;
        $rental->save();
    
        return redirect()->back()->with('success', 'Rental created successfully!');
    }
    
    public function show($id) {
        // Show a specific rental property
        $rental = House::findOrFail($id);
        return view('landlord.rentals.showRental', compact('rental'));
    }
    public function edit($id) {
        // Edit a specific rental property
        return view('admin.listings.edit', compact('id'));
    } 
    public function update(Request $request, $id) {
        // Validate and update the rental property
        // Redirect or return a response
    }
    public function destroy($id) {
        $rental = House::findOrFail($id);
        $rental->delete();

        return redirect()->route('landlord.history')->with('success', 'User deleted successfully.');
        // Delete a specific rental property
        // Redirect or return a response
    }

    public function landlordRentals() {
        // Fetch rentals for a specific landlord
        $landlordId = Auth::user();
        // dd($landlordId);
        $rentals = House::where('landlord_id', $landlordId->id)->get();

        return view('landlord.layouts.history', compact('rentals'));
    }
}
