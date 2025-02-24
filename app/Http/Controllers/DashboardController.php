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
            $search = $request->input('search');
            $query->where('label', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $keys = $query->get();

        return Inertia::render('Dashboard2', [
            'keys' => $keys,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

}
