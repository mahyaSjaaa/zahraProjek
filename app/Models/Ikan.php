<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ikan extends Model
{
    use HasFactory;

    // Nama tabel (opsional, tapi kita tegaskan)
    protected $table = 'ikans';

    // Primary key (default 'id', ini opsional juga)
    protected $primaryKey = 'id';

    // Karena tabel dibuat manual dan TIDAK ada created_at / updated_at
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'kategori',
        'harga',
        'stok',
        'deskripsi',
        'gambar',
    ];
}
