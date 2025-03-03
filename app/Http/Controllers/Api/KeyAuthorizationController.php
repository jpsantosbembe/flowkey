<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Key;
use App\Models\KeyAuthorization;
use App\Models\User;
use Illuminate\Http\Request;

class KeyAuthorizationController extends Controller
{
    public function getUserKeys($userId)
    {
        $user = User::findOrFail($userId);

        $keys = Key::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get(['id', 'label', 'description']);

        return response()->json($keys);
    }

    public function addAuthorization(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'key_id' => ['required', 'integer', 'exists:keys,id'],
        ]);

        $authorization = KeyAuthorization::where('user_id', $validated['user_id'])
            ->where('key_id', $validated['key_id'])
            ->first();

        if ($authorization) {
            $authorization->update(['is_active' => true]);
        } else {
            KeyAuthorization::create([
                'user_id' => $validated['user_id'],
                'key_id' => $validated['key_id'],
                'is_active' => true,
            ]);
        }

        return response()->json(['message' => 'Usuário autorizado com sucesso!'], 200);
    }

    /**
     * Remove (desativa) a autorização de um usuário para uma chave.
     */
    public function removeAuthorization(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:key_authorizations,user_id'],
            'key_id' => ['required', 'integer', 'exists:key_authorizations,key_id'],
        ]);

        // Busca a autorização correspondente
        $authorization = KeyAuthorization::where('user_id', $validated['user_id'])
            ->where('key_id', $validated['key_id'])
            ->first();

        if (!$authorization) {
            return response()->json(['message' => 'Autorização não encontrada.'], 404);
        }

        // Desativa a autorização, ao invés de deletá-la
        $authorization->update(['is_active' => false]);

        return response()->json(['message' => 'Acesso removido com sucesso!'], 200);
    }
}
