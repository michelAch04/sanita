<?php


namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use App\Models\Page;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('query')) {
            $search = $request->query('query');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "{$search}%")
                    ->orWhere('name', 'like', "{$search}%")
                    ->orWhere('email', 'like', "{$search}%");
            });
        }

        $users = $query->get();

        if ($request->ajax()) {
            return view('cms.permission.index', compact('users'))->renderSections()['permissions_list'];
        }

        return view('cms.permission.index', compact('users'));
    }


    public function create(Request $request)
    {
        $users = User::all();
        $user = null;
        if ($request->user_id) {
            $user = User::find($request->user_id);
        }
        $pages = Page::all();
        return view('cms.permission.create', compact('users', 'user', 'pages'));
    }



    public function update(Request $request)
    {
        $request->validate([
            'users_id' => 'required|exists:users,id',
            'permissions' => 'required|array',
        ]);

        $userId = $request->input('users_id');
        $permissions = $request->input('permissions', []);

        foreach ($permissions as $pageId => $fields) {
            $perm = Permission::firstOrNew([
                'users_id' => $userId,
                'pages_id' => $pageId,
            ]);
            $perm->pages_id = $pageId;
            $perm->view = isset($fields['view']) ? 1 : 0;
            $perm->add = isset($fields['add']) ? 1 : 0;
            $perm->edit = isset($fields['edit']) ? 1 : 0;
            $perm->delete = isset($fields['delete']) ? 1 : 0;
            $perm->excel = isset($fields['excel']) ? 1 : 0;
            $perm->save();
        }
        dd($permissions);

        return redirect()->back()->with('success', 'Permissions updated successfully.');
    }
}
