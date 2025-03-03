<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function getUserActiveLoans($userId)
    {
        $loans = Loan::where('borrowed_by_user_id', $userId)
            ->whereNull('returned_at')
            ->with([
                'key:id,label,description',
                'givenBy:id,name',
                'returnedBy:id,name'
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

    public function getCoordinatorLoans($userId)
    {
        $user = User::findOrFail($userId);

        if (!$user->hasRole('Coordenador')) {
            return response()->json([
                'message' => 'Usuário não é um coordenador.'
            ], 403);
        }

        $loans = Loan::whereHas('key.coordinators', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->whereNull('returned_at')
            ->with([
                'key:id,label,description',
                'borrowedBy:id,name',
                'givenBy:id,name',
                'returnedBy:id,name'
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
