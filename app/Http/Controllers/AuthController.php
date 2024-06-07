<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request){
        $registerUserData = $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8',
            'role'=>'required|string|exists:roles,name'
        ]);
        $user = User::create([
            'name' => $registerUserData['name'],
            'email' => $registerUserData['email'],
            'password' => Hash::make($registerUserData['password']),
        ]);

        $user->assignRole($registerUserData['role']);

        return response()->json([
            'message' => 'User Created ',
        ]);
    }

    public function login(Request $request){
        $loginUserData = $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|min:8'
        ]);
        $user = User::where('email',$loginUserData['email'])->first();
        if(!$user || !Hash::check($loginUserData['password'],$user->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
        $user->getPermissionsViaRoles();
        return response()->json([
            'user' => $user,
            'access_token' => $token,
        ]);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
    
        return response()->json([
          "message"=>"logged out"
        ]);
    }

    public function getCurrentUser(){
        $currentUser = Auth::user();
        $user = User::where('id', $currentUser->id)->first();
        $user->getPermissionsViaRoles();
    
        return response()->json([
          "message"=>"Current user",
          "data" => $user
        ]);
    }
}
