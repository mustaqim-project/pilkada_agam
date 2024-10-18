<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all permissions
        $permissions = Permission::select('id', 'name', 'guard_name', 'group_name', 'created_at', 'updated_at')->get();

        // Pass permissions data to the view
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return a view with a form to create a new permission
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'guard_name' => 'required|string|max:255',
            'group_name' => 'required|string|max:255',
        ]);

        // Create a new permission
        Permission::create($validated);

        // Redirect to the index page with a success message
        return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Find the permission by id
        $permission = Permission::findOrFail($id);

        // Pass the permission data to the edit view
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'guard_name' => 'required|string|max:255',
            'group_name' => 'required|string|max:255',
        ]);

        // Find the permission by id and update
        $permission = Permission::findOrFail($id);
        $permission->update($validated);

        // Redirect to the index page with a success message
        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the permission by id and delete
        $permission = Permission::findOrFail($id);
        $permission->delete();

        // Redirect to the index page with a success message
        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
