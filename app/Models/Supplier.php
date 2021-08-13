<?php

namespace App\Models;

use App\Models\Produk;
use App\Models\PurchaseOrder;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory, HasUuid;
    protected $table = 'suppliers';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'nama',
        'email',
        'telpon',
        'alamat',
        'status'
    ];

    public function products()
    {
        return $this->hasMany(Produk::class, 'supplier_id', 'id');
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'supplier_id', 'id');
    }
}
