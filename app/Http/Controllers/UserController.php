<?php

namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use App\Helpers\ApiResponse;

class UserController extends Controller
{
     public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if ($request->has('email')) {

                if (!$token = auth()->attempt($credentials)) {
                    return ApiResponse::error('Invalid email or password', 401);
                }

                $user = auth()->user();

                return ApiResponse::success([
                    'id' => $user->id,
                    'name' => $user->full_name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'token' => $token,
                ], 'Login successful');
            }

            return ApiResponse::error('Email is required', 422);

        } catch (\Exception $e) {
            return ApiResponse::error('Failed to login', $e->getMessage());
        }
    }

    public function logout()
    {
        try {
            auth()->guard()->logout();
            return ApiResponse::success(null, 'Logout successful');
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to logout', $e->getMessage());
        }
    }
}
