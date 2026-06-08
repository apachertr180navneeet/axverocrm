<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RefreshToken;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
class AuthController extends Controller
{
    // public function login(Request $request)
    // {
    //     // Validate
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     // Attempt login
    //     if (!Auth::attempt($request->only('email', 'password'))) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid credentials'
    //         ], 401);
    //     }

    //     $user = Auth::user();

    //     // Delete old tokens (optional but recommended)
    //     $user->tokens()->delete();

    //     // Create token
    //     $token = $user->createToken('api-token')->plainTextToken;

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Login successful',
    //         'token' => $token,
    //         'user' => $user
    //     ]);
    // }
    
public function login(Request $request)
{
    // Validate
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // Attempt login
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    $user = Auth::user();

    // Delete old tokens
    $user->tokens()->delete();
    $user->refreshTokens()->delete();

    // 🔹 Access Token (24 hours)
    $token = $user->createToken('api-token')->plainTextToken;

    // 🔹 Refresh Token (1 year)
    $plainRefreshToken = Str::random(64);

    RefreshToken::create([
        'user_id' => $user->id,
        'token' => hash('sha256', $plainRefreshToken),
        'expires_at' => Carbon::now()->addYear()
    ]);

    // Response SAME structure + refresh_token add
    return response()->json([
        'status' => true,
        'message' => 'Login successful',
        'token' => $token, // same as before
        'refresh_token' => $plainRefreshToken, // new
        'token_type' => 'Bearer',
        'expires_in' => 86400, // 24h
        'user' => $user
    ]);
}
    
    
    public function profile(Request $request)
{
    return response()->json($request->user());
}

public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Logged out']);
}


    public function refreshToken(Request $request)
    {
        $request->validate([
            'refresh_token' => 'required'
        ]);
    
        $hashedToken = hash('sha256', $request->refresh_token);
    
        $token = RefreshToken::where('token', $hashedToken)->first();
    
        if (!$token || $token->isExpired()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired refresh token'
            ], 401);
        }
    
        $user = $token->user;
    
        $newAccessToken = $user->createToken('api-token')->plainTextToken;
    
        return response()->json([
            'status' => true,
            'token' => $newAccessToken,
            'token_type' => 'Bearer',
            'expires_in' => 86400
        ]);
    }
}