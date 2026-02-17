<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;

class DosenPengajuanController extends Controller
{
    public function index(){
        $pengajuan = Pengajuan::with(['user', 'jenisSurat', 'pengajuanTtd'])->whereHas('pengajuanTtd', function($query) {
            $query->where('dosen_id', auth()->id());
        })->get();

        return view('dosen.pengajuan.index', compact('pengajuan'));
    }
}