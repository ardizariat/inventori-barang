<?php

namespace App\Models;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangMasuk extends Model
{
    use HasFactory, HasUuid;

    public $incrementing = false;
    protected $with = ['product'];
    protected $table = 'barang_masuk';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'produk_id',
        'jumlah',
        'tanggal',
        'keterangan',
        'penerima',
        'pemberi',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
