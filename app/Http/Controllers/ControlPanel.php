<?php

namespace App\Http\Controllers;

use App\Models\Key;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ControlPanel extends Controller
{
    public function index(Request $request)
    {
        $query = Key::with(['loans', 'users']);

        if ($request->has('search') && $request->search != '') {
            $search = strtolower($request->input('search'));

            $query->whereRaw('LOWER(label) LIKE ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(description) LIKE ?', ["%{$search}%"]);
        }

        $keys = $query->paginate(3)->withQueryString();

        return Inertia::render('ControlPanel', [
            'keys'        => $keys,
            'roles' => auth()->user()->getRoleNames(),
        ]);
    }
}
