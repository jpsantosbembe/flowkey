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
        $campi = Campus::orderBy('id')->get();
        return Inertia::render('Campi/Index', [
            'campi' => $campi,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Campi/Create',[
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
        ]);

        Campus::create([
            'nome' => $validated['nome'],
        ]);

        return redirect()->route('campi.index')->with('success', 'Campus created successfully');
    }

    public function show(Campus $campus)
    {
        return Inertia::render('Campus/Show', [
            'campi' => $campus,
        ]);
    }

    public function edit(Campus $campus)
    {
        return Inertia::render('Campus/Edit', [
            'campus' => $campus,
        ]);
    }

    public function update(Request $request, Campus $campus)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
        ]);

        $campus->update([
            'nome' => $validated['nome'],
        ]);

        return redirect()->route('campi.index')->with('success', 'Campus updated successfully');
    }
}
