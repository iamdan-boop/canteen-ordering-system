<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Authentication\LoginRequest;
use App\Http\Requests\Api\Authentication\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid Email or Password',
                'response_code' => 404
            ]);
        }
        return response([
            'auth_token' => $user->createToken('app_token')->plainTextToken,
        ], 201);
    }


    public function register(RegisterUserRequest $request) 
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('app_token')->plainTextToken;
        return response(['auth_token' => $token], 201);
    }
}
