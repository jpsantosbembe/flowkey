<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id')->paginate(2);
        return Inertia::render('Users/Index', [
            'users' => $users,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('users.index');
    }

    public function create()
    {
        return Inertia::render('Users/Create',[
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function show(User $user)
    {
        return Inertia::render('Users/Show', [
            'users' => $user,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'users' => $user,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
        ]);
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
}
