<?php

namespace App\Models;

use App\Models\PB;
use App\Models\PR;
use App\Models\User;
use App\Models\Produk;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangKeluar extends Model
{
    use HasFactory, HasUuid;

    public $incrementing = false;
    protected $with = ['product'];
    protected $table = 'barang_keluar';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'produk_id',
        'pb_id',
        'pr_id',
        'penerima',
        'qty',
        'subtotal',
        'jenis_permintaan',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
    public function pb()
    {
        return $this->belongsTo(PB::class, 'pb_id', 'id');
    }
    public function pr()
    {
        return $this->belongsTo(PR::class, 'pr_id', 'id');
    }
    public function penerimaBarang()
    {
        return $this->belongsTo(User::class, 'penerima', 'id');
    }
}
