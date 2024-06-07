<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::get();
        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role = Role::create($request->all());
        return response()->json($role, 201);
    }

    public function show($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return response()->json($role);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role = Role::where('id', $id)->first();    

        if($role){
            $role->update($request->all());
        }
        return response()->json($role);
    }

    public function syncPermissionsToRole(Request $request, $id){
        $role = Role::where('id', $id)->first();
        $permissions = $request->input('permissions');
        $role->syncPermissions();
        $role->syncPermissions($permissions);
        return response()->json($role);
    
    }

}
