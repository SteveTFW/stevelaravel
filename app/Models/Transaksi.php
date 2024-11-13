<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'tanggal',
        'nama_supplier',
        'bahan_baku_id',
        'jumlah',
        'harga_satuan',
        'total_harga',
        'metode_pembayaran',
        'status',
        'cara_pengiriman',
        'catatan_tambahan',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function bahanBaku(){
        return $this->belongsTo('App\Models\BahanBaku', 'bahan_baku_id', 'id');
    }
}
