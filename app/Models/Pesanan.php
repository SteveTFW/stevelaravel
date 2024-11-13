<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'user_id',
        'tanggal',
        'alamat_pengiriman',
        'metode_pembayaran',
        'total_harga',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function detailPesanan() {
        return $this->hasMany('App\Models\Pesanan', 'pesanan_id');
    }
}
