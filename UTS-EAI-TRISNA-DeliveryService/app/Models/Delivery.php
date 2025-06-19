<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'nama_pelanggan',
        'alamat_pengiriman',
        'kurir',
        'status_pengiriman',
        'nomor_resi',
        'estimasi_tiba',
    ];
}
