<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CoordinatorsKeys;
use App\Models\User;
use Illuminate\Http\Request;

class CoordinatorKeysController extends Controller
{
    public function getCoordinatorKeys($userId)
    {
        $keys = CoordinatorsKeys::where('user_id', $userId)
            ->with('key:id,label,description')
            ->get();

        return response()->json($keys);
    }

    public function getLaboratoryAccess($userId, $keyId)
    {
        $coordinatorKey = CoordinatorsKeys::with([
            'key.authorizations' => function ($q) {
                $q->where('is_active', true)->with('user'); // Apenas autorizações ativas com informações do usuário
            },
            'user'
        ])
            ->where('user_id', $userId)
            ->where('key_id', $keyId)
            ->first();

        if (!$coordinatorKey) {
            return response()->json([
                'message' => 'Nenhum acesso encontrado para este coordenador e chave.'
            ], 404);
        }

        return response()->json($coordinatorKey);
    }

    public function searchUsers(Request $request)
    {
        $searchTerm = $request->input('query');

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'Discente');
        })
            ->when($searchTerm, function ($query) use ($searchTerm) {
                return $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $searchTerm . '%');
                });
            })
            ->limit(10)
            ->get(['id', 'name', 'email']);

        return response()->json($users);
    }
}
