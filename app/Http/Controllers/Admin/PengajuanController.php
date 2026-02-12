<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\JenisSurat;
use App\Models\User;

class PengajuanController extends Controller
{
    public function index(){
        $pengajuan = Pengajuan::with(['user', 'jenisSurat'])->get();

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
            
            // Update database
            $pengajuan->update([
                'file_surat_jadi' => $path,
                'status' => 'diterima', 
            ]);
        }

        return redirect()->route('admin.pengajuan.index')->with('success', 'Surat berhasil diunggah dan status diperbarui.');
    }

    public function decline($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->update([
            'status' => 'ditolak',
        ]);

        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan surat telah ditolak.');
    }

}
