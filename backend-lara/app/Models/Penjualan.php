<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total', 'tanggal'];

    public function details()
    {
        return $this->hasMany(DetailPenjualan::class);
    }

    public function kasir()
    {
        return $this->belongsTo(User::class);
    }
}
