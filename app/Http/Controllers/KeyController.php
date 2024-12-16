<?php

namespace App\Http\Controllers;

use App\Models\Guardhouse;
use App\Models\Key;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KeyController extends Controller
{
    //
    public function index()
    {
        $keys = Key::with('guardhouse')->orderBy('id')->get();
        return Inertia::render('Keys/Index',[
            'keys' => $keys,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function create()
    {
        $guardhouses = Guardhouse::orderBy('name')->get();
        return Inertia::render('Keys/Create',[
            'guardhouses' => $guardhouses,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'guardhouse_id' => ['required', 'integer', 'exists:guardhouses,id'],
        ]);

        Key::create([
            'label' => $validated['label'],
            'description' => $validated['description'],
            'guardhouse_id' => $validated['guardhouse_id'],
        ]);

        return redirect()->route('keys.index')->with('success', 'Key created successfully');
    }

    public function show(Key $key) {
        $key->load('guardhouse');
        //dd($key);
        return Inertia::render('Keys/Show', [
            'iKey' => $key,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function edit(Key $key) {
        $guardhouses = Guardhouse::orderBy('id')->get();
        //dd([$key, $guardhouses]);
        return Inertia::render('Keys/Edit', [
            'iKey' => $key,
            'guardhouses' => $guardhouses,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function update(Request $request, Key $key) {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'guardhouse_id' => ['required', 'integer', 'exists:guardhouses,id'],
        ]);

        $key->update([
            'label' => $validated['label'],
            'description' => $validated['description'],
            'guardhouse_id' => $validated['guardhouse_id'],
        ]);

        return redirect()->route('keys.index')->with('success', 'Key updated successfully');
    }
}
