<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::withTrashed()->get();
        return response()->json($properties);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image_url' => 'nullable|url',
            'price' => 'required|numeric',
            'address' => 'required',
            'seller_id' => 'required|exists:users,id',
        ]);

        $property = Property::create($request->all());
        return response()->json($property, 201);
    }

    public function show($id)
    {
        $property = Property::withTrashed()->findOrFail($id);
        return response()->json($property);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'image_url' => 'nullable|url',
            'price' => 'required|numeric',
            'address' => 'required',
            'seller_id' => 'required|exists:users,id',
        ]);

        $property = Property::where('id', $id)->first();

        if($property){
            $property->update($request->all());
        }

        return response()->json($property);
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $property = Property::withTrashed()->findOrFail($id);
        $property->restore();
        return response()->json($property);
    }
}
