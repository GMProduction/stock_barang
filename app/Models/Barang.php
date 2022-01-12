<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'barcode',
        'nama',
        'satuan',
        'harga',
        'gambar',
        'jenis_barang_id',
    ];

    public function jenis()
    {
        return $this->belongsTo(JenisBarang::class, 'jenis_barang_id');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'barang_id');
    }

    public function allStock()
    {
        return $this->hasMany(Stock::class, 'barang_id');
    }

    public function getCabangStockAttribute()
    {
        $total = 0;
        $stock = $this->stock()->where('');
//        if($stock !== null) {
//            $total = $stock->qty;
//        }
        return $stock;
    }

    public function getTotalStockAttribute()
    {
        $total = 0;
        foreach ($this->allStock()->get() as $item) {
            $total += $item->qty;
        }
        return $total;
    }
}
