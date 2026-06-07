<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('user_id', 'desc')->paginate(10);
        $roles = Role::all();
        return view('users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,role_id',
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'status' => 'required|in:Active,Inactive'
        ]);

        User::create([
            'role_id' => $request->role_id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status' => $request->status
        ]);

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        // $role = Role::find($user->role_id);
        return view('users.show', compact('user', 'role'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role_id' => 'required|exists:roles,role_id',
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id . ',user_id',
            'phone' => 'nullable|string|max:20',
            'username' => 'required|string|max:50|unique:users,username,' . $id . ',user_id',
            'password' => 'nullable|string|min:6|confirmed',
            'status' => 'required|in:Active,Inactive'
        ]);

        $data = [
            'role_id' => $request->role_id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'status' => $request->status
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    // public function destroy($id)
    // {
    //     $user = User::findOrFail($id);
        
    //     if (auth()->check() && $user->user_id === auth()->id()) {
    //         return redirect()->route('user.index')->with('error', 'You cannot delete your own account.');
    //     }
        
    //     $user->delete();
    //     return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    // }
    
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $newStatus = $user->status === 'Active' ? 'Inactive' : 'Active';
        $user->update(['status' => $newStatus]);
        return redirect()->route('user.index')->with('success', 'User status updated successfully.');
    }
}