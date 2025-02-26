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
        $guardhouses = Guardhouse::with('campus')->orderBy('id')->paginate(3);
        return Inertia::render('Guardhouses/Index', [
            'guardhouses' => $guardhouses,
            'roles' => auth()->user()->getRoleNames(),
        ]);
    }

    public function show(Guardhouse $guardhouse){
        $guardhouse->load('campus');
        //dd($guardhouse->campus->toArray());
        return Inertia::render('Guardhouses/Show', [
            'guardhouse' => $guardhouse,
            'roles' => auth()->user()->getRoleNames(),
            'guardhouse_campus' => [$guardhouse->campus->toArray()] ,
        ]);
    }

    public function create(){
        $campuses = Campus::orderBy('name')->get();
        //dd($campuses);
        return Inertia::render('Guardhouses/Create',[
            'campuses' => $campuses,
            'roles' => auth()->user()->getRoleNames(),
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
        $campuses = Campus::orderBy('id')->get();

        return Inertia::render('Guardhouses/Edit', [
            'guardhouse' => $guardhouse,
            'campuses' => $campuses,
            'roles' => auth()->user()->getRoleNames(),
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
