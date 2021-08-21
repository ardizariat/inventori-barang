<?php

namespace App\Models;

use App\Models\User;
use App\Models\BarangKeluar;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PB extends Model
{

    use HasFactory, HasUuid;
    public $incrementing = false;
    protected $table = 'pb';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'no_dokumen',
        'pemohon',
        'total_item',
        'total_harga',
        'keterangan',
        'sect_head',
        'tgl_approve_sect',
        'dept_head',
        'tgl_approve_dept',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'pemohon', 'id');
    }
    public function stockOuts()
    {
        return $this->hasMany(BarangKeluar::class, 'pb_id', 'id');
    }
    public function pbDetails()
    {
        return $this->hasMany(PBDetail::class, 'pb_id', 'id');
    }
}
