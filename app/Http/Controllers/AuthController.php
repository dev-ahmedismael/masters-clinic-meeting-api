<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->all());
        $user->createToken('register')->plainTextToken;
        $user->assignRole($request->input('role'));
        $user->save();
        $user->load('roles');
        $response = [
            'user' => $user,
            'roles' =>  $request->input('role'),
            'message' => 'تم إضافة العضو بنجاح.'
        ];

        return response()->json($response, 201);
    }

    // Login
    public function login(LoginRequest $request)
    {
        // Check email
        $user = User::where('email', $request->email)->with('roles')->first();

        if (!$user) {
            return response()->json([
                'message' => 'البريد الإلكتروني غير مسجل على النظام.'
            ], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'كلمة المرور غير صحيحة'
            ], 401);
        }

        $token = $user->createToken('login')->plainTextToken;

        $redirect_path = '';
        if ($user->hasRole('admin')) {
            $redirect_path = 'admin';
        } elseif ($user->hasRole('doctor')) {
            $redirect_path = 'doctor';
        } elseif ($user->hasRole('customer_service')) {
            $redirect_path = 'customer-service';
        }

        $response = [
            'user' => $user,
            'token' => $token,
            'path' => $redirect_path
        ];

        return response()->json($response, 200);
    }

    // Logout
    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json(['message' => 'تم تسجيل الخروج بنجاح.'], 200);
    }
}
