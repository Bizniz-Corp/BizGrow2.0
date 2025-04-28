<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'penjualans'; // Pastikan ini sesuai dengan nama tabel di database

    protected $fillable = [
        'tanggal',
        'nama_produk',
        'harga',
        'kuantitas',
    ];
}
