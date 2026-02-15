<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';

    protected $fillable = [
        'nim',
        'user_id',
        'jenis_surat_id',
        'berkas',
        'status',
        'file_surat_jadi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function pengajuanTtd()
    {
        return $this->hasOne(PengajuanTtd::class, 'pengajuan_id');
    }
}
