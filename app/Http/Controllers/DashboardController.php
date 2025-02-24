<?php

namespace App\Http\Controllers;

use App\Models\Key;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Key::with(['loans', 'users']);

        if ($request->has('search') && $request->search != '') {
            $search = strtolower($request->input('search')); // Converte para minúsculas

            $query->whereRaw('LOWER(label) LIKE ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(description) LIKE ?', ["%{$search}%"]);
        }

        $keys = $query->paginate(3)->withQueryString();

        return Inertia::render('Dashboard2', [
            'keys'        => $keys,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }
}
