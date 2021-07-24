<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory, HasUuid;
    public $incrementing = false;
    protected $table = 'setting';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'nama_aplikasi',
        'telepon',
        'logo',
        'alamat',
        'deskripsi'
    ];

    public function getLogo()
    {
        return $this->logo ? asset('/storage/setting/' . $this->logo) : asset('/images/default/default.png');
    }
}
