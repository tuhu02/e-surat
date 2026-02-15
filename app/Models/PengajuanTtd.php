<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanTtd extends Model
{
    protected $table = 'pengajuan_ttd';

    protected $fillable = [
        'file_ttd',
        'keterangan',
        'pengajuan_id',
        'user_id',
        'status',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
