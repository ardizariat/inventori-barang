<?php

namespace App\Models;

use App\Models\Produk;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangKeluar extends Model
{
    use HasFactory, HasUuid;

    public $incrementing = false;
    protected $with = ['product', 'pb'];
    protected $table = 'barang_keluar';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'produk_id',
        'pb_id',
        'penerima',
        'pemberi',
        'qty',
        'status_barang',
    ];

    public function product()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
    public function pb()
    {
        return $this->belongsTo(PB::class, 'pb_id', 'id');
    }
    public function pemberiBarang()
    {
        return $this->belongsTo(User::class, 'pemberi', 'id');
    }
    public function penerimaBarang()
    {
        return $this->belongsTo(User::class, 'penerima', 'id');
    }
}
