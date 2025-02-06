<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = ['distributor_id', 'total', 'tanggal'];

    public function details()
    {
        return $this->hasMany(DetailPembelian::class);
    }

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }
}
