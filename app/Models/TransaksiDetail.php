<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'item_id',
        'jumlah',
        'harga_satuan'
    ];

    // Relasi ke barang
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // Relasi ke transaksi induk
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}

