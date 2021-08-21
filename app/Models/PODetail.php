<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PODetail extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'po_detail';
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'po_id',
        'produk_id',
        'qty',
        'harga',
        'subtotal'
    ];

    public function po()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
