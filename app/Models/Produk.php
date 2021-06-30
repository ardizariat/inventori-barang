<?php

namespace App\Models;

use App\Models\Kategori;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory, HasUuid;
    public $incrementing = false;
    public $with = ['kategori', 'gudang'];
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
        'gambar1',
        'gambar2',
        'gambar3',
        'keterangan',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }
}
