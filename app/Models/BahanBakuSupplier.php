<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBakuSupplier extends Model
{
    protected $fillable = [
        'supplier_id',
        'bahan_baku_id',
        'harga_supplier',
    ];

    public function supplier() {
        return $this->belongsTo('App\Models\Supplier', 'supplier_id', 'id');
    }

    public function bahanBaku() {
        return $this->belongsTo('App\Models\BahanBaku', 'bahan_baku_id', 'id');
    }
}
