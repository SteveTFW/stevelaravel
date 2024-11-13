<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'nama',
        'gambar',
        'harga',
        'deskripsi',
        'kategori_id',
    ];

    public function kategori() {
        return $this->belongsTo('App\Models\Kategori', 'kategori_id', 'id');
    }

    public function detailPesanan() {
        return $this->hasMany('App\Models\DetailPesanan', 'produk_id');
    }

    public function detailBahanBakuProduk() {
        return $this->hasMany('App\Models\DetailBahanBakuProduk','produk_id');
    }
}
