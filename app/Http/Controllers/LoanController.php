<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['borrowedBy', 'givenBy', 'returnedBy', 'receivedBy', 'key'])->orderBy('id')->paginate(3);
        return Inertia::render('Loans/Index', [
            'loans' => $loans,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function show(Loan $loan){
        $loan->load(['borrowedBy', 'givenBy', 'returnedBy', 'receivedBy', 'key']);
        return Inertia::render('Loans/Show', [
            'loan' => $loan,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }
}
