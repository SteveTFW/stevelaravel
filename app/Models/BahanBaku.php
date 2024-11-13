<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    protected $fillable = [
        'nama',
        'harga_per_satuan',
        'stok_kuantitas',
        'jenis_satuan',
    ];

    public function detailBahanBakuProduk() {
        return $this->hasMany('App\Models\DetailBahanBakuProduk','bahan_baku_id');
    }

    public function transaksi() {
        return $this->hasMany('App\Models\Transaksi','bahan_baku_id');
    }

    public function bahanBakuSupplier() {
        return $this->hasMany('App\Models\BahanBakuSupplier','bahan_baku_id');
    }
}
