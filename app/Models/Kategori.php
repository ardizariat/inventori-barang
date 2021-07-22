<?php

namespace App\Models;

use App\Models\Produk;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory, HasUuid;

    public $incrementing = false;
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'kategori',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Produk::class, 'kategori_id', 'id');
    }

    public function stokIns()
    {
        return $this->hasManyThrough(
            BarangMasuk::class,
            Produk::class,
            'kategori_id',
            'produk_id'
        );
    }

    public function stokOuts()
    {
        return $this->hasManyThrough(
            BarangKeluar::class,
            Produk::class,
            'kategori_id',
            'produk_id'
        );
    }
}
