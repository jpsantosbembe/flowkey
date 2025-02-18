<?php

namespace App\Http\Controllers;

use App\Models\CoordinatorsKeys;
use App\Models\Key;
use App\Models\KeyAuthorization;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CoordinatorKeysController extends Controller
{
    public function index()
    {
        $coordinatorKeys = CoordinatorsKeys::with(['user', 'key'])->orderBy('id')->paginate(3);
        //dd($coordinatorKeys);
        return Inertia::render('CoordinatorKeys/Index', [
            'coordinatorsKeys' => $coordinatorKeys,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function create()
    {
        $users = User::orderBy('id')->get();
        $keys = Key::orderBy('id')->get();
        return Inertia::render('CoordinatorKeys/Create', [
            'users' => $users,
            'keys' => $keys,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id', 'integer'],
            'key_id' => ['required', 'exists:keys,id', 'integer'],
        ]);

        CoordinatorsKeys::create([
            'user_id' => $validated['user_id'],
            'key_id' => $validated['key_id'],
        ]);

        return redirect()->route('coordinatorkeys.index')->with('success', 'Coordinator Key created successfully.');
    }

    public function show(CoordinatorsKeys $coordinatorsKeys)
    {
        $coordinatorsKeys->load(['user', 'key']);
        return Inertia::render('CoordinatorKeys/Show', [
            'coordinatorsKeys' => $coordinatorsKeys,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function edit(CoordinatorsKeys $coordinatorsKeys)
    {
        $coordinatorsKeys->load(['user', 'key']);
        $users = User::orderBy('id')->get();
        $keys = Key::orderBy('id')->get();
        return Inertia::render('CoordinatorKeys/Edit', [
            'coordinatorsKeys' => $coordinatorsKeys,
            'users' => $users,
            'keys' => $keys,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);

    }

    public function update(Request $request, CoordinatorsKeys $coordinatorsKeys)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id', 'integer'],
            'key_id' => ['required', 'exists:keys,id', 'integer'],
        ]);

        $coordinatorsKeys->update([
            'user_id' => $validated['user_id'],
            'key_id' => $validated['key_id'],
        ]);

        return redirect()->route('coordinatorkeys.index')->with('success', 'Coordinator Key updated successfully.');
    }

    public function destroy($id)
    {

    }
}
