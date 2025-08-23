<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'diskon'
    ];

    // Relasi: satu transaksi punya banyak detail barang
    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
