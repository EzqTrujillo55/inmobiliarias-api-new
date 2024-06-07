<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return response()->json($users);
    }



    public function byRole($role)
    {
        $users = User::role($role)->get();
        return response()->json($users);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8',
            'role'=>'required|string|exists:roles,name'
        ]);

        $user = User::where('id', $id)->first();

        if($user){
            $user->update($request->all());
        }

        return response()->json($user);
    }


}
