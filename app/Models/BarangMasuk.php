<?php

namespace App\Models;

use App\Models\PO;
use App\Models\Produk;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangMasuk extends Model
{
    use HasFactory, HasUuid;

    public $incrementing = false;
    protected $with = ['po'];
    protected $table = 'barang_masuk';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'po_id',
        'produk_id',
        'penerima',
        'qty',
        'subtotal',
        'status',
    ];

    public function po()
    {
        return $this->belongsTo(PO::class, 'po_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
