<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $tenants = User::whereHas('roles', function($query) {
            $query->where('name', 'tenant');
        })->get();
    
        $landlords = User::whereHas('roles', function($query) {
            $query->where('name', 'landlord');
        })->get();
    
        return view('admin.users.index', compact('tenants', 'landlords'));
    }

    public function store(Request $request) {
        $request->validate([
            'first_name' => 'required|string',
            'email' => 'required|string',
        ]);

        User::create([
            'name' => $request->first_name,
            'email' => $request->email,
            'password' => bcrypt('123456')
        ]);

        return redirect()->back();
    }

    public function show() {
        
    }

    public function edit() {
        
    }

    public function update() {
        
    }

    public function destroy($id) {
        
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
