<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::with('merek')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'merek_id' => 'required|exists:mereks,id',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    public function show($id)
    {
        return response()->json(Product::with('merek')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json($product);
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
