<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id',
        'kode',
        'nama_pelanggan',
        'no_hp',
        'alamat',
        'metode_pembayaran',
        'kurir',
        'total',
    ];


    public function items()
    {
        return $this->hasMany(TransaksiItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
