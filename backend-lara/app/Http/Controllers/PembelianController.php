<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index()
    {
        return response()->json(Pembelian::with('distributor', 'details.product')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'distributor_id' => 'required|exists:distributors,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $total_harga = collect($request->items)->sum(fn($item) => $item['jumlah'] * $item['harga']);

            $pembelian = Pembelian::create([
                'distributor_id' => $request->distributor_id,
                'total_harga' => $total_harga
            ]);

            foreach ($request->items as $item) {
                DetailPembelian::create([
                    'pembelian_id' => $pembelian->id,
                    'product_id' => $item['product_id'],
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                ]);

                Product::where('id', $item['product_id'])->increment('stock', $item['jumlah']);
            }
        });

        return response()->json(['message' => 'Pembelian berhasil disimpan']);
    }
}
