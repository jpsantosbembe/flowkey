<?php

namespace App\Http\Controllers;

use App\Models\Guardhouse;
use App\Models\Key;
use App\Models\KeyAuthorization;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KeyController extends Controller
{
    //
    public function index()
    {
        $keys = Key::with('guardhouse')->orderBy('id')->paginate(3);
        return Inertia::render('Keys/Index',[
            'keys' => $keys,
            'roles' => auth()->user()->getRoleNames(),
        ]);
    }

    public function indexApi(Request $request)
    {
        $query = Key::with(['guardhouse','users']);

        if (request('search') && !empty($request->search)) {
            $query->orderByRaw("CASE WHEN label LIKE ? THEN 0 ELSE 1 END", ['%' . $request->search . '%']);
        }

        $keys = $query->orderBy('id')->get();
        return $keys;
    }

    public function create()
    {
        $guardhouses = Guardhouse::orderBy('name')->get();
        return Inertia::render('Keys/Create',[
            'guardhouses' => $guardhouses,
            'roles' => auth()->user()->getRoleNames(),
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
            'roles' => auth()->user()->getRoleNames(),
            'key_coordinators' => $key->coordinators,
            'key_users' => $key->users,
        ]);
    }

    public function edit(Key $key) {
        $guardhouses = Guardhouse::orderBy('id')->get();
        //dd([$key, $guardhouses]);
        return Inertia::render('Keys/Edit', [
            'iKey' => $key,
            'guardhouses' => $guardhouses,
            'roles' => auth()->user()->getRoleNames(),
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
