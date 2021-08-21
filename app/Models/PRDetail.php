<?php

namespace App\Models;

use App\Models\PR;
use App\Models\Produk;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PRDetail extends Model
{
    use HasFactory, HasUuid;
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'pr_detail';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'pb_id',
        'produk_id',
        'qty',
        'harga',
        'subtotal',
    ];

    public function pr()
    {
        return $this->belongsTo(PR::class, 'pr_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
