<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $tenants = User::with(['info', 'roles'])
            ->whereHas('roles', function($query) {
                $query->where('role_name', 'tenant');
            })->get();
    
        $landlords = User::with(['info', 'roles'])
            ->whereHas('roles', function($query) {
                $query->where('role_name', 'landlord');
            })->get();

        return view('admin.users.index', compact('tenants', 'landlords'));
    }

    public function store(Request $request) {
        $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'contact_number' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'role' => 'required|in:landlord,tenant',
        ]);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => bcrypt('123456')
        ]);

        // Create user info
        $user->info()->create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'contact_number' => $request->contact_number,
        ]);

        $role = Role::where('role_name', $request->role)->firstOrFail();
        $user->roles()->attach($role->id);

        return redirect()->back()->with('success', 'User created successfully');
    }

    public function show($id) {
        $user = User::with(['info', 'roles'])->findOrFail($id);
        
        // If user info doesn't exist, create a default one
        if (!$user->info) {
            $names = explode(' ', $user->name);
            $firstName = $names[0];
            $lastName = end($names);
            
            $user->info = UserInfo::create([
                'user_id' => $user->id,
                'first_name' => $firstName,
                'last_name' => $lastName,
            ]);
        }

        return response()->json([
            'user' => $user,
            'info' => $user->info,
            'role' => $user->roles->first() ? $user->roles->first()->role_name : 'unknown'
        ]);
    }

    public function edit($id) {
        $user = User::with(['info', 'roles'])->findOrFail($id);
        
        // If user info doesn't exist, create a default one
        if (!$user->info) {
            $names = explode(' ', $user->name);
            $firstName = $names[0];
            $lastName = end($names);
            
            $user->info = UserInfo::create([
                'user_id' => $user->id,
                'first_name' => $firstName,
                'last_name' => $lastName,
            ]);
        }

        return response()->json([
            'user' => $user,
            'info' => $user->info,
            'role' => $user->roles->first() ? $user->roles->first()->role_name : 'unknown'
        ]);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'contact_number' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'role' => 'required|in:landlord,tenant',
        ]);

        $user = User::findOrFail($id);
        
        // Update user
        $user->update([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
        ]);

        // Update or create user info
        $user->info()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'birth_date' => $request->birth_date,
                'contact_number' => $request->contact_number,
            ]
        );

        // Update role if changed
        $newRole = Role::where('role_name', $request->role)->firstOrFail();
        $user->roles()->sync([$newRole->id]);

        return response()->json(['message' => 'User updated successfully']);
    }

    public function destroy($id) {
        try {
            $user = User::findOrFail($id);
            $userType = $user->roles->first() ? $user->roles->first()->role_name : 'user';
            
            // Delete user info if exists
            if ($user->info) {
                $user->info->delete();
            }
            
            // Delete role associations
            $user->roles()->detach();
            
            // Delete the user
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => ucfirst($userType) . ' deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting user: ' . $e->getMessage()
            ], 500);
        }
    }
}
