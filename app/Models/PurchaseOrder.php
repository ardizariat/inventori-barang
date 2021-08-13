<?php

namespace App\Models;

use App\Models\BarangMasuk;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrder extends Model
{
    use HasFactory, HasUuid;

    public $incrementing = false;
    protected $table = 'purchase_order';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'no_dokumen',
        'supplier_id',
        'total_harga',
        'total_item',
        'status',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function purchaseOrderDetails()
    {
        return $this->hasMany(PurchaseOrderDetail::class, 'purchase_order_id', 'id');
    }

    public function stockIn()
    {
        return $this->hasOne(BarangMasuk::class, 'purchase_order_id', 'id');
    }
}
