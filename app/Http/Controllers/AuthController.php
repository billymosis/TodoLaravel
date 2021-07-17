<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'last_sync' => now('utc')
        ]);


        $token = $user->createToken('myapptoken')->plainTextToken;
        $user->token_text = $token;
        $user->save();
        $response = ['user' => $user, 'token' => $token];

        return response($response, 201);
    }

    public function login(Request $request)
    {

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // check email
        $user = User::where('email', $fields['email'])->first();

        // check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'wrong password or email'], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        $user->token_text = $token;
        $user->save();
        $response = ['user' => $user, 'token' => $token];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response(['message' => 'logged out'],200);
    }
}
