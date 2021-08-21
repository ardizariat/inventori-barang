<?php

namespace App\Models;

use App\Models\PB;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PBDetail extends Model
{
    use HasFactory, HasUuid;
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'pb_detail';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'pb_id',
        'produk_id',
        'qty',
        'harga',
        'subtotal',
    ];

    public function pb()
    {
        return $this->belongsTo(PB::class, 'pb_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
