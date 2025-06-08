<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = User::where('id', '!=', auth()->id()); // 👈 exclude current user

            if ($request->filled('query')) {
                $search = $request->query('query');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "$search%")
                        ->orWhere('email', 'like', "$search%");
                });
            }

            $users = $query->where('cancelled', 0)->get();

            if ($request->ajax()) {
                return view('cms.users.index', compact('users'))->renderSections()['users_list'];
            }

            return view('cms.users.index', compact('users'));
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Failed to fetch users: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('cms.users.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            // First, check if the user exists and is cancelled
            $existingUser = User::where('email', $validate['email'])->first();

            if ($existingUser) {
                if ($existingUser->cancelled == 1) {
                    // Reactivate cancelled user
                    $existingUser->name = $validate['name'];
                    if (!empty($validate['password'])) {
                        $existingUser->password = Hash::make($validate['password']);
                    }
                    $existingUser->remember_token = Str::random(60);
                    $existingUser->cancelled = 0;
                    $existingUser->save();

                    return redirect()->route('users.index')->with('success', 'User reactivated successfully.');
                } else {
                    // Email already taken by an active user
                    return redirect()->back()->withInput()->withErrors(['email' => 'The email has already been taken.']);
                }
            }

            // If no user exists, create new user
            User::create([
                'name' => $validate['name'],
                'email' => $validate['email'],
                'password' => Hash::make($validate['password']),
                'remember_token' => Str::random(60),
                'cancelled' => 0,
            ]);

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }



    public function edit(User $user)
    {
        return view('cms.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'remember_token' => Str::random(60),
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        try {
            $user->update(['cancelled' => 1]);

            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}
