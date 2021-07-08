<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    use HasFactory, HasUuid;

    public $incrementing = false;
    protected $table = 'gudang';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'nama',
        'kode',
        'lokasi',
        'status'
    ];
    public function products()
    {
        return $this->hasMany(Produk::class, 'gudang_id', 'id');
    }
}
