<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
        public function login(Request $request): JsonResponse
    {
        $attributes = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ]);

        if(! Auth::attempt($attributes)) {
            $data = [
                'status' => 'unsuccessful',
                'error' => "Sorry, the credentials doesn't match our record",
            ];
            return response()->json(['data' => $data], 401);
        }

        $authToken = Auth::user()->createToken('Auth Token')->accessToken;

        $data = [
            'status' => "success",
            // 'user' => new UserResource(Auth::user()),
            'authToken' => $authToken,
        ];

        return response()->json(['data' => $data], 202);
    }
}
