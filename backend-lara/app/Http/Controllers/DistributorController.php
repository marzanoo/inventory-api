<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function index()
    {
        return response()->json(Distributor::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'contact' => 'required|string',
            'address' => 'required|string',
        ]);

        $distributor = Distributor::create($request->all());
        return response()->json($distributor, 201);
    }

    public function show($id)
    {
        return response()->json(Distributor::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $distributor = Distributor::findOrFail($id);
        $distributor->update($request->all());
        return response()->json($distributor);
    }

    public function destroy($id)
    {
        Distributor::findOrFail($id)->delete();
        return response()->json(['message' => 'Distributor deleted successfully']);
    }
}
