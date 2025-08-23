<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kategori',
        'stok',
        'harga',
    ];

    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
