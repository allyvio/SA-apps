<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show()
    {
        try {
            $data = User::findOrFail(Auth::user()->id);
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil didapatkan!',
                'data' => $data,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 200);
        }
    }
}
