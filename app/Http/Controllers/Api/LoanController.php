<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function getUserActiveLoans($userId)
    {
        $loans = Loan::where('borrowed_by_user_id', $userId)
            ->whereNull('returned_at')
            ->with([
                'key:id,label,description', // Carrega informações da chave
                'givenBy:id,name', // Nome do usuário que entregou a chave
                'returnedBy:id,name' // Nome do usuário que devolveu a chave
            ])
            ->get([
                'id',
                'borrowed_by_user_id',
                'given_by_user_id',
                'borrowed_key_id',
                'returned_by_user_id',
                'receiver_user_id',
                'borrowed_at',
                'returned_at'
            ]);

        return response()->json($loans);
    }
}
