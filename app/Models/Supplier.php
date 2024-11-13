<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'nama',
        'alamat',
        'nomor_telepon',
        'email',
    ];

    public function bahanBakuSupplier() {
        return $this->hasMany('App\Models\BahanBakuSupplier','supplier_id');
    }
}
