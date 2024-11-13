<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBahanBakuProduk extends Model
{
    protected $fillable = [
        'produk_id',
        'bahan_baku_id',
        'jumlah',
    ];

    public function produk()
    {
        return $this->belongsTo('App\Models\Produk', 'produk_id', 'id');
    }

    public function bahanBaku()
    {
        return $this->belongsTo('App\Models\BahanBaku', 'bahan_baku_id', 'id');
    }
}
