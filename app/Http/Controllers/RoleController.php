<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(10);
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:50|unique:roles,role_name'
        ]);

        Role::create($request->all());

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);
        return view('roles.show', compact('role'));
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'role_name' => 'required|string|max:50|unique:roles,role_name,' . $id . ',role_id'
        ]);

        $role->update($request->all());

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        
        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')
                ->with('error', 'Cannot delete role with associated users.');
        }
        
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}