<?php

namespace App\Models;

use App\Models\Produk;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrderDetail extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'purchase_order_detail';
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'purchase_order_id',
        'produk_id',
        'qty',
        'harga',
        'subtotal'
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
