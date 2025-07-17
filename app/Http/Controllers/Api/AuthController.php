<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

 public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }    
    $code = rand(100000, 999999); // 6-digit code
    $user = User::create([
        'name'              => $request->name,
        'email'             => $request->email,
        'password'          => Hash::make($request->password),
        'verification_code' => $code,
    ]);

    // Send email with the code 
    Mail::raw("Your verification code is: $code", function ($message) use ($user) {
        $message->to($user->email)->subject('Email Verification Code');
    });
    $token = $user->createToken('auth_token')->plainTextToken;
    return response()->json([
        'message' => 'User registered successfully. Verification code sent via email.',
        'user'    => new UserResource($user),
        'token'   => $token,
    ]);

}

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email','code'  => 'required|digits:6',
        ]);
        $user = User::where('email', $request->email)
            ->where('verification_code', $request->code)->first();
        if (!$user) {
            return response()->json(['message' => 'Invalid code.'], 400);
        }
        $user->is_verified = true;
        $user->verification_code = null;
        $user->save();
        return response()->json(['message' => 'Email verified.'], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password))
            return response()->json(['message' => 'Invalid credentials.'], 401);
        if (!$user->is_verified) {
        return response()->json(['message' => 'Email not verified.'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
              'message' => 'Login successful.',
              'user'    => new UserResource($user),
             'token'   => $token,], 200);
         }
}



