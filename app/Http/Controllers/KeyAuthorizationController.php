<?php

namespace App\Http\Controllers;

use App\Models\Key;
use App\Models\KeyAuthorization;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KeyAuthorizationController extends Controller
{
    //
    public function index()
    {
        $keyAuthorization = KeyAuthorization::with(['user', 'key'])->orderBy('id')->get();
        //dd($keyAuthorization);
        return Inertia::render('KeyAuthorizations/Index',[
            'keyAuthorizations' => $keyAuthorization,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function show(KeyAuthorization $keyAuthorization){
        $keyAuthorization->load(['user', 'key']);
        return Inertia::render('KeyAuthorizations/Show', [
            'keyAuthorization' => $keyAuthorization,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function create(){
        $users = User::orderBy('id')->get();
        $keys = Key::orderBy('id')->get();
        return Inertia::render('KeyAuthorizations/Create',[
            'users' => $users,
            'keys' => $keys,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'key_id' => ['required', 'integer', 'exists:keys,id'],
            'is_active' => ['required', 'boolean'],
        ]);

        KeyAuthorization::create([
            'user_id' => $validated['user_id'],
            'key_id' => $validated['key_id'],
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->route('keyauthorizations.index')->with('success', 'Key Authorization created successfully');
    }

    public function edit(KeyAuthorization $keyAuthorization){
        $keyAuthorization->load(['user', 'key']);
        $users = User::orderBy('id')->get();
        $keys = Key::orderBy('id')->get();
        //dd($keyAuthorization);
        return Inertia::render('KeyAuthorizations/Edit', [
            'keyAuthorization' => $keyAuthorization,
            'users' => $users,
            'keys' => $keys,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function update(Request $request, KeyAuthorization $keyAuthorization){
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'key_id' => ['required', 'integer', 'exists:keys,id'],
            'is_active' => ['required', 'boolean'],
        ]);

        $keyAuthorization->update([
            'user_id' => $validated['user_id'],
            'key_id' => $validated['key_id'],
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->route('keyauthorizations.index')->with('success', 'Key Authorization updated successfully');
    }
}
