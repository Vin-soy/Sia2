<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $tenants = User::whereHas('roles', function($query) {
            $query->where('role_name', 'tenant');
        })->get();
    
        $landlords = User::whereHas('roles', function($query) {
            $query->where('role_name', 'landlord');
        })->get();

        return view('admin.users.index', compact('tenants', 'landlords'));
    }

    public function store(Request $request) {

        $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email', // Assuming you're using unique email            
            'contact_number' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'role' => 'required|in:landlord,tenant',
        ]);
        $user = User::create([
            'name' => $request->first_name,
            'email' => $request->email,
            'password' => bcrypt('123456')
        ]);
        $user->info()->create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'contact_number' => $request->contact_number,
        ]);
        $role = Role::where('role_name', $request->role)->firstOrFail();
        $user->roles()->attach($role->id);

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
