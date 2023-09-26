<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ],[
                'username.required' => 'Username harus diisi',
                'password.required' => 'Password harus diisi'
            ]);
        
            $otentifikasi = request(['username', 'password']);
        
            if (Auth::attempt($otentifikasi)) {
                $user = User::where('username', $request->username)->first();
        
                if (Hash::check($request->password, $user->password)) {
                    $tokenResult = $user->createToken('authToken')->plainTextToken;
                    return response()->json([
                        'access_token' => $tokenResult,
                        'token_type' => 'Bearer',
                        'data' => $user,
                        'message' => 'Sukses, Berhasil login'
                    ], 200);
                } else {
                    return response()->json(['message' => 'Error, Validasi Gagal'], 401);
                }
            } else {
                return response()->json(['message' => 'Error, Validasi Gagal'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
        
        
    }

    public function logout(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $user->tokens()->delete();
        return response()->json(['message' => 'Sukses, Berhasil Logout'], 201);
    }
}
