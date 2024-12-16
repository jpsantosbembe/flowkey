<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Guardhouse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GuardhouseController extends Controller
{
    //
    public function index()
    {
        $guardhouses = Guardhouse::with('campus')->orderBy('id')->get();
        return Inertia::render('Guardhouses/Index', [
            'guardhouses' => $guardhouses,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function show(Guardhouse $guardhouse){
        $guardhouse->load('campus');
        return Inertia::render('Guardhouses/Show', [
            'guardhouse' => $guardhouse,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function create(){
        $campuses = Campus::orderBy('name')->get();
        //dd($campuses);
        return Inertia::render('Guardhouses/Create',[
            'campuses' => $campuses,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'campus_id' => ['required', 'integer', 'exists:campuses,id'],
        ]);

        Guardhouse::create([
            'name' => $validated['name'],
            'campus_id' => $validated['campus_id'],
        ]);

        return redirect()->route('guardhouses.index')->with('success', 'Guardhouse created successfully');
    }

    public function edit(Guardhouse $guardhouse){
        $campuses = Campus::orderBy('name')->get();

        return Inertia::render('Guardhouses/Edit', [
            'guardhouse' => $guardhouse,
            'campuses' => $campuses,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function update(Request $request, Guardhouse $guardhouse){
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'campus_id' => ['required', 'integer', 'exists:campuses,id'],
        ]);

        $guardhouse = $guardhouse->update([
            'name' => $validated['name'],
            'campus_id' => $validated['campus_id'],
        ]);

        return redirect()->route('guardhouses.index')->with('success', 'Guardhouse updated successfully');
    }

}
