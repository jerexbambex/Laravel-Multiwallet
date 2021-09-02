<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();

        $data = [
            'status' => 'success',
            'data' => UserResource::collection($users),
        ];

        return response()->json($data, 200);
    }

    public function show(User $user)
    {
        $user = User::with(['wallets', 'transactions'])->find($user->id);

        $data = [
            'status' => 'success',
            'data' => new UserResource($user),
        ];

        return response()->json($data, 200);
    }
}
