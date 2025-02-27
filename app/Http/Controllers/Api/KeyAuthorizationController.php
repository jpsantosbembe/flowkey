<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Key;
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
}
