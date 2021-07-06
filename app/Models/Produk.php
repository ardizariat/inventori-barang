<?php

namespace App\Models;

use App\Models\Kategori;
use App\Models\BarangMasuk;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory, HasUuid;
    public $incrementing = false;
    protected $with = ['barangMasuks', 'kategori', 'gudang'];
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
    ];

    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class, 'produk_id');
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }

    public function getGambar()
    {
        return $this->gambar ? asset('/storage/barang/' . $this->gambar) : asset('/images/default/default.png');
    }
}