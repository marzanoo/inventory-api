<?php

namespace App\Http\Controllers;

use App\Models\Merek;
use Illuminate\Http\Request;

class MerekController extends Controller
{
    public function index()
    {
        return response()->json(Merek::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $merek = Merek::create($request->all());
        return response()->json($merek, 201);
    }

    public function show($id)
    {
        return response()->json(Merek::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $merek = Merek::findOrFail($id);
        $merek->update($request->all());
        return response()->json($merek);
    }

    public function destroy($id)
    {
        Merek::findOrFail($id)->delete();
        return response()->json(['message' => 'Merek deleted successfully']);
    }
}
