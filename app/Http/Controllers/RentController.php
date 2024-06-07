<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;

class RentController extends Controller
{
    public function index()
    {
        $rents = Rent::withTrashed()->get();
        return response()->json($rents);
    }

    public function store(Request $request)
    {
        $request->validate([
            'renter_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id'
        ]);

        $rent = Rent::create($request->all());
        return response()->json($rent, 201);
    }

    public function show($id)
    {
        $rent = Rent::withTrashed()->findOrFail($id);
        return response()->json($rent);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'renter_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id'
        ]);

        $rent = Rent::where('id', $id)->first();    

        if($rent){
            $rent->update($request->all());
        }
        return response()->json($rent);
    }

    public function destroy($id)
    {
        $rent = Rent::findOrFail($id);
        $rent->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $rent = Rent::withTrashed()->findOrFail($id);
        $rent->restore();
        return response()->json($rent);
    }
}
