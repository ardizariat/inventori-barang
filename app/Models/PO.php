<?php

namespace App\Models;

use App\Models\PR;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PO extends Model
{
    use HasFactory, HasUuid;

    public $incrementing = false;
    protected $table = 'po';
    protected $with = ['pr', 'supplier'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'no_dokumen',
        'supplier_id',
        'pr_id',
        'total_harga',
        'total_item',
        'status',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function pr()
    {
        return $this->belongsTo(PR::class, 'pr_id', 'id');
    }

    public function poDetails()
    {
        return $this->hasMany(PODetail::class, 'po_id', 'id');
    }

    public function stockIn()
    {
        return $this->hasOne(BarangMasuk::class, 'po_id', 'id');
    }
}
