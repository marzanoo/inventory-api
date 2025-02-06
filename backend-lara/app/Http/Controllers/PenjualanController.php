<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        return response()->json(Penjualan::with('kasir', 'details.product')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'kasir_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $total_harga = collect($request->items)->sum(fn($item) => $item['jumlah'] * $item['harga']);

            $penjualan = Penjualan::create([
                'kasir_id' => $request->kasir_id,
                'total_harga' => $total_harga
            ]);

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['jumlah']) {
                    throw new \Exception('Stock tidak mencukupi untuk produk: ' . $product->name);
                }

                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'product_id' => $item['product_id'],
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                ]);

                $product->decrement('stock', $item['jumlah']);
            }
        });

        return response()->json(['message' => 'Penjualan berhasil disimpan']);
    }
}
