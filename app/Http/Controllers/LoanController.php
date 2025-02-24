<?php

namespace App\Http\Controllers;

use App\Models\Key;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['borrowedBy', 'givenBy', 'returnedBy', 'receivedBy', 'key'])
            ->orderBy('id')
            ->paginate(3);
        return Inertia::render('Loans/Index', [
            'loans'       => $loans,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function show(Loan $loan)
    {
        $loan->load(['borrowedBy', 'givenBy', 'returnedBy', 'receivedBy', 'key']);
        return Inertia::render('Loans/Show', [
            'loan'        => $loan,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
        ]);
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $keys  = Key::orderBy('id')->get();

        return Inertia::render('Loans/Create', [
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
            'users'       => $users,
            'keys'        => $keys,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'borrowed_by_user_id' => 'required|exists:users,id',
            'given_by_user_id'    => 'required|exists:users,id',
            'borrowed_key_id'     => 'required|exists:keys,id',
            'returned_by_user_id' => 'nullable|exists:users,id',
            'receiver_user_id'    => 'nullable|exists:users,id',
            'borrowed_at'         => 'required|date',
            'returned_at'         => 'nullable|date',
            'redirect_to'         => 'nullable|string', // Adicione o campo
        ]);

        Loan::create($validated);

        // Pega a URL de redirecionamento, se não tiver, usa padrão
        $redirectTo = $request->input('redirect_to', route('loans.index'));

        return redirect()->to($redirectTo)->with('success', 'Empréstimo criado com sucesso!');
    }

    public function edit(Loan $loan)
    {
        $loan->load(['borrowedBy', 'givenBy', 'returnedBy', 'receivedBy', 'key']);

        $users = User::orderBy('name')->get();
        $keys  = Key::orderBy('id')->get();

        return Inertia::render('Loans/Edit', [
            'loan'        => $loan,
            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
            'users'       => $users,
            'keys'        => $keys,
        ]);
    }

    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'returned_at'         => 'required|date',
            'returned_by_user_id' => 'required|exists:users,id',
            'receiver_user_id'    => 'required|exists:users,id',
            'redirect_to'         => 'nullable|string',
        ]);

        // Captura o redirect_to enviado; se não existir, usa a rota padrão
        $redirectTo = $validated['redirect_to'] ?? route('loans.index');

        $loan->update($validated);

        return redirect()->to($redirectTo)->with('success', 'Empréstimo atualizado com sucesso!');
    }


}
