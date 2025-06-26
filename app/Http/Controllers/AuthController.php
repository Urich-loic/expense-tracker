<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Register(Request $request)
    {
        $user_info = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = User::create($user_info);
        $token = $user->createToken($request->name)->plainTextToken;

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function Login(Request $request)
    {
        $user_info = $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!Hash::check($request->password, $user->password) === true) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }
        $token = $user->createToken($user->name)->plainTextToken;

        return response()->json([
            'message' => 'Welcome back',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function Logout(Request $request)
    {

        $request->user()->tokens()->delete();
        return "Your are logged out";
    }
}
