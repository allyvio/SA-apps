<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $validatedData['password'] = bcrypt($request->password);
        $validatedData['phone'] = $request->get('phone');
        $user = User::create($validatedData);
        $accessToken = $user->createToken('authToken')->accessToken;
        return response()->json([
            'success' => true,
            'message' => 'Mohon untuk cek email untuk memverifikasi',
            'data' => $user,
            'access_token' => $accessToken
        ], 200);
    }
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        $emailVerify = User::where('email', $request->get('email'));
        if (!auth()->attempt($loginData)) {
            return response()->json([
                'success' => false,
                'message' => 'Email dan password tidak cocok',
            ], 200);
        }
        if ($emailVerify != null && $emailVerify->value('email_verified_at') ==  null) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan verifikasi email anda terlebih dahulu',
            ], 200);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }
}
