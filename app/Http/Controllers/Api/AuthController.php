<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   //API Login
   public function login(Request $request) {
    $request->validate([
        'email'=>'required|email',
        'password'=>'required',
    ]);

    $user = User::where('email', $request->email)->first();

    //Check user
    if(!$user) {
        return response()->json([
            'error'=>'User not found'
        ], 404);
    }

    //Check password
    if(!Hash::check($request->password, $user->password)) {
        return response()->json([
            'status'=>'error',
            'message' => 'Password is not match'
        ], 404);
    }

    //If validate
    $token = $user->createToken('token')->plainTextToken;

    return response()->json([
        'token'=>$token,
        'user'=>$user,
    ]);
   }

    //API Logout
   public function logout(Request $request) {
   $request->user()->currentAccessToken()->delete();

    return response()->json([
        'status'=>'Success',
        'message' => 'Logout Successfully'
    ]);
   }
}
