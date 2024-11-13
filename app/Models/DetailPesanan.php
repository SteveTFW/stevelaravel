<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';

    protected $fillable = [
        'pesanan_id',
        'produk_id',
        'jumlah',
        'biaya_tambahan',
        'deskripsi',
        'gambar',
        'status',
    ];

    public function pesanan()
    {
        return $this->belongsTo('App\Models\Pesanan', 'pesanan_id', 'id');
    }

    public function produk()
    {
        return $this->belongsTo('App\Models\Produk', 'produk_id', 'id');
    }
}
