<?php


namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::with('user')->get();
        return view('cms.permission.index', compact('permissions'));
    }

    public function create()
    {
        $users = User::all();
        return view('cms.permission.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'can_view' => 'required|boolean',
        ]);

        Permission::create($request->only(['user_id', 'name', 'can_view']));

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $users = User::all();
        return view('cms.permission.edit', compact('permission', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'can_view' => 'required|boolean',
            'can_edit' => 'required|boolean',
            'can_delete' => 'required|boolean',
            'can_add' => 'required|boolean',
            'can_excel' => 'required|boolean',
        ]);

        $permission = Permission::findOrFail($id);
        $permission->update($request->only(['user_id', 'name', 'can_view', 'can_edit', 'can_delete', 'can_add', 'can_excel']));

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->update(['cancelled' => 1]);

        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
