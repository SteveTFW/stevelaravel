<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peran extends Model
{
    protected $table = 'peran';

    protected $fillable = [
        'nama',
        'deskripsi',
        'kode',
    ];

    public function user() {
        return $this->hasMany('App\Models\User','peran_id');
    }
}
