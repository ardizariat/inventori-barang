<?php

namespace App\Models;

use App\Models\Produk;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory, HasUuid;

    public $incrementing = false;

    protected $table = 'kategori';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'kategori',
        'status'
    ];

    public function produks()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}
