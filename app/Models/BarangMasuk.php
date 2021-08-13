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
    protected $with = ['purchaseOrder'];
    protected $table = 'barang_masuk';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'purchase_order_id',
        'no_dokumen',
        'status',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }
}
