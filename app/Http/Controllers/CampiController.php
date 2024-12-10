<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CampiController extends Controller
{
    //
    public function index()
    {
        $campi = User::oderBy('id')->get();
        return Inertia::render('Campi/Index', [
            'campi' => $campi,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        Campi::create([
            'name' => $validated['name'],
        ]);
        return redirect()->route('campi.index')->with('success', 'Campi created successfully');
    }

    public function show(Campi $campi)
    {
        return Inertia::render('Campi/Show', [
            'campi' => $campi,
        ]);
    }

    public function edit(Campi $campi)
    {
        return Inertia::render('Campi/Edit', [
            'campi' => $campi,
        ]);
    }

    public function update(Request $request, Campi $campi)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
        ]);

        $campi->update([
            'nome' => $validated['nome'],
        ]);

        return redirect()->route('campi.index')->with('success', 'Campi updated successfully');
    }
}
