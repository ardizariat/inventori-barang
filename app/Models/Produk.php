<?php

namespace App\Models;

use App\Models\Gudang;
use App\Models\Kategori;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory, HasUuid;
    public $incrementing = false;
    protected $with = ['category', 'warehouse'];
    protected $table = 'produk';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'kategori_id',
        'gudang_id',
        'kode',
        'nama_produk',
        'merek',
        'satuan',
        'minimal_stok',
        'stok',
        'gambar',
        'keterangan',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id', 'id');
    }

    public function stockIns()
    {
        return $this->hasMany(BarangMasuk::class, 'produk_id', 'id');
    }

    public function stockOuts()
    {
        return $this->hasMany(BarangKeluar::class, 'produk_id', 'id');
    }

    public function getGambar()
    {
        return $this->gambar ? asset('/storage/barang/' . $this->gambar) : asset('/images/default/default.png');
    }
}
