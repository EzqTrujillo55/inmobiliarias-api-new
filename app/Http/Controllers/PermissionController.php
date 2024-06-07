<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::get();
        return response()->json($permissions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $permission = Permission::create($request->all());
        return response()->json($permission, 201);
    }

    public function show($id)
    {
        $permission = Permission::findOrFail($id);
        return response()->json($permission);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $permission = Permission::where('id', $id)->first();    

        if($permission){
            $permission->update($request->all());
        }
        return response()->json($permission);
    }

}
