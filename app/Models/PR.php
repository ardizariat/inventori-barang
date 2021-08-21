<?php

namespace App\Models;

use App\Models\PO;
use App\Models\User;
use App\Models\PRDetail;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PR extends Model
{
    use HasFactory, HasUuid;
    public $incrementing = false;
    protected $table = 'pr';
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
        'direktur',
        'tgl_approve_direktur',
        'status',
        'status_po',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'pemohon', 'id');
    }

    public function prDetails()
    {
        return $this->hasMany(PRDetail::class, 'pr_id', 'id');
    }

    public function po()
    {
        return $this->hasOne(PO::class, 'pr_id', 'id');
    }
}
