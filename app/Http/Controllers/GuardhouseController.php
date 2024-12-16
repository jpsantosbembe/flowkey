<?php

namespace App\Http\Controllers;

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

}
