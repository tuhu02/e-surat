<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\JenisSurat;
use App\Models\User;

class SuratController extends Controller
{
    public function index(){
        $pengajuan = Pengajuan::with(['user', 'jenisSurat'])->get();

        return view('admin.surat.index', compact('pengajuan'));
    }

    public function store($id){
        $pengajuan = Pengajuan::findOrFail($id);

        if($pengajuan){
            return view('admin.')
        }
    }


}
