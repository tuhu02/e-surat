<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Events\PengajuanCreated;
use App\Events\PengajuanStatusUpdated;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\JenisSurat;
use App\Models\User;


class PengajuanController extends Controller
{
    public function index(){
        $pengajuan = Pengajuan::with(['user', 'jenisSurat'])->paginate(10);
        return view('admin.pengajuan.index', compact('pengajuan'));
    }

    public function create($id)
    {
        $pengajuan = Pengajuan::with('user', 'jenisSurat')->findOrFail($id);
        return view('admin.pengajuan.create', compact('pengajuan'));
        
    }

    public function storeUpload(Request $request, $id)
    {
        $request->validate([
            'file_surat_jadi' => 'required|mimes:pdf|max:2048',
        ]);

        $pengajuan = Pengajuan::with('user', 'jenisSurat')->findOrFail($id);

        if ($request->hasFile('file_surat_jadi')) {
            $path = $request->file('file_surat_jadi')->store('surat_jadi', 'public');
            
            $pengajuan->update([
                'file_surat_jadi' => $path,
                'status' => 'diterima', 
            ]);
        }

        broadcast(new PengajuanStatusUpdated($pengajuan));

        return redirect()->route('admin.pengajuan.index')->with('success', 'Surat berhasil diunggah dan status diperbarui.');
    }

    public function decline($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->update([
            'status' => 'ditolak',
        ]);

        broadcast(new PengajuanStatusUpdated($pengajuan));

        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan surat telah ditolak.');
    }

}