<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\PengajuanTtd;
use App\Models\User;


class PengajuanTtdController extends Controller
{
    public function index(){
        $pengajuan = Pengajuan::with(['user', 'jenisSurat'])->where('user_id',auth()->id())->where('status', 'diterima')->get();
        $dosen = User::role('dosen')->get();
        return view('mahasiswa.pengajuan-ttd',compact('pengajuan','dosen'));
    }

    public function store(Request $request){
        $request->validate([
            'pengajuan_id' => 'required|exists:pengajuan,id',
        ]);

        $id = $request->input('pengajuan_id');
        $catatan = $request->input('catatan');
        $dosenId = $request->input('dosen');

        PengajuanTtd::create([
            'pengajuan_id' => $id,
            'user_id' => auth()->id(),
            'status' => 'pending',
            'dosen_id' => $dosenId,
            'keterangan' => $catatan,
        ]);

        return redirect()->route('mahasiswa.pengajuan.ttd.index')->with('success', 'Tanda tangan berhasil disimpan.');
    }
}
