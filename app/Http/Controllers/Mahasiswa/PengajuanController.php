<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index()
    {
        $jenisSurat = JenisSurat::all();
        return view('mahasiswa.meminta-surat', compact('jenisSurat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:255',
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'berkas' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $berkasPath = null;
        if ($request->hasFile('berkas')) {
            $berkasPath = $request->file('berkas')->store('pengajuan', 'public');
        }

        Pengajuan::create([
            'nim' => $request->nim,
            'user_id' => auth()->id(),
            'jenis_surat_id' => $request->jenis_surat_id,
            'berkas' => $berkasPath,
        ]);

        return redirect()->route('mahasiswa.meminta-surat')->with('success', 'Pengajuan surat berhasil dikirim!');
    }
}
