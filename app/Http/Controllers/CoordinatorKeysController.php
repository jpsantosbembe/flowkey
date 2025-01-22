<?php

namespace App\Http\Controllers;

use App\Models\CoordinatorsKeys;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CoordinatorKeysController extends Controller
{
    public function index() {
        $coordinatorKeys = CoordinatorsKeys::with(['user', 'key'])->orderBy('id')->get();
        //dd($coordinatorKeys);
        return Inertia::render('CoordinatorKeys/Index', [
            'coordinatorsKeys' => $coordinatorKeys,
            'permissions' => auth()->user()->getAllPermissions(),
        ]);

    }

    public function create() {

    }

    public function store(Request $request) {

    }

    public function show($id) {

    }

    public function edit($id) {

    }

    public function update(Request $request, $id) {

    }

    public function destroy($id) {

    }
}
