<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
