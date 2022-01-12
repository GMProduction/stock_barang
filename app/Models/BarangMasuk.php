<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $table = 'barang_masuk';

    protected $fillable = [
        'barang_id',
        'cabang_id',
        'user_id',
        'tanggal',
        'qty',
        'keterangan'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
