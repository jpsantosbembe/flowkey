<?php

namespace App\Http\Controllers;

use App\Models\Key;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Inertia\Inertia;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['borrowedBy', 'givenBy', 'returnedBy', 'receivedBy', 'key'])
            ->orderBy('id', 'DESC')
            ->paginate(3);
        return Inertia::render('Loans/Index', [
            'loans'       => $loans,
            'roles' => auth()->user()->getRoleNames(),
        ]);
    }

    public function show(Loan $loan)
    {
        $loan->load(['borrowedBy', 'givenBy', 'returnedBy', 'receivedBy', 'key']);
        return Inertia::render('Loans/Show', [
            'loan'        => $loan,
            'roles' => auth()->user()->getRoleNames(),
        ]);
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $keys  = Key::orderBy('id')->get();

        return Inertia::render('Loans/Create', [
            'roles' => auth()->user()->getRoleNames(),
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
            'roles' => auth()->user()->getRoleNames(),
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

        $redirectTo = $validated['redirect_to'] ?? route('loans.index');

        $loan->update($validated);

        return redirect()->to($redirectTo)->with('success', 'Empréstimo atualizado com sucesso!');
    }

    public function history(Request $request)
    {
        // Carrega os empréstimos com os relacionamentos necessários, incluindo os usuários da chave
        $loans = Loan::with([
            'borrowedBy:id,name',
            'givenBy:id,name',
            'returnedBy:id,name',
            'receivedBy:id,name',
            'key:id,label',
            'key.users:id,name'
        ])->orderBy('id', 'DESC')->get();

        $events = collect();

        foreach ($loans as $loan) {
            // Força a conversão do objeto Loan para array para garantir que todas as relações sejam serializadas
            $loanArray = $loan->toArray();

            if ($loan->borrowed_at) {
                $events->push([
                    'type'      => 'retirada',
                    'timestamp' => $loan->borrowed_at,
                    'user'      => $loan->borrowedBy ? $loan->borrowedBy->name : 'Desconhecido',
                    'key'       => $loan->key ? $loan->key->label : 'Sem chave',
                    'loan_id'   => $loan->id,
                    'loan'      => $loanArray,
                ]);
            }

            if ($loan->returned_at) {
                $events->push([
                    'type'      => 'devolução',
                    'timestamp' => $loan->returned_at,
                    'user'      => $loan->returnedBy ? $loan->returnedBy->name : 'Desconhecido',
                    'key'       => $loan->key ? $loan->key->label : 'Sem chave',
                    'loan_id'   => $loan->id,
                    'loan'      => $loanArray,
                ]);
            }
        }

        // Ordena os eventos por data (mais recentes primeiro)
        $sortedEvents = $events->sortByDesc('timestamp')->values();

        // Paginação manual para os eventos
        $perPage = 2;
        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $currentEvents = $sortedEvents->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginatedEvents = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentEvents,
            $sortedEvents->count(),
            $perPage,
            $currentPage,
            [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]
        );

        return Inertia::render('Loans/History', [
            'events'      => $paginatedEvents,
            'roles' => auth()->user()->getRoleNames(),
        ]);
    }

    //TODO barra de pesquisa

}
