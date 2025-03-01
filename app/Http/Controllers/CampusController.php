<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CampusController extends Controller
{
    //
    public function index()
    {
        $campi = Campus::orderBy('id')->paginate(3);
        return Inertia::render('Campuses/Index', [
            'campuses' => $campi,
            'roles' => auth()->user()->getRoleNames(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Campuses/Create',[
            'roles' => auth()->user()->getRoleNames(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        Campus::create([
            'name' => $validated['name'],
        ]);

        return redirect()->route('campuses.index')->with('success', 'Campus created successfully');
    }

    public function show(Campus $campus)
    {
        return Inertia::render('Campuses/Show', [
            'campus' => $campus,
            'roles' => auth()->user()->getRoleNames(),
            'campus_guardhouses' => $campus->campusGuardhouses,
        ]);
    }

    public function edit(Campus $campus)
    {
        return Inertia::render('Campuses/Edit', [
            'campus' => $campus,
            'roles' => auth()->user()->getRoleNames(),
        ]);
    }

    public function update(Request $request, Campus $campus)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $campus->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('campuses.index')->with('success', 'Campus updated successfully');
    }
}
