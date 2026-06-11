<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;

class DosenDashboardController extends Controller
{
    public function index()
    {
        $dosenId = auth()->id();

        // Total pengajuan TTD
        $totalPengajuanTtd = Pengajuan::with(['user', 'jenisSurat', 'pengajuanTtd'])
            ->whereHas('pengajuanTtd', function ($query) use ($dosenId) {
                $query->where('dosen_id', $dosenId);
            })
            ->count();

        // Pending TTD
        $pendingTtd = Pengajuan::with(['user', 'jenisSurat', 'pengajuanTtd'])
            ->whereHas('pengajuanTtd', function ($query) use ($dosenId) {
                $query->where('dosen_id', $dosenId)
                    ->where('status', 'pending');
            })
            ->count();

        // Selesai TTD
        $selesaiTtd = Pengajuan::with(['user', 'jenisSurat', 'pengajuanTtd'])
            ->whereHas('pengajuanTtd', function ($query) use ($dosenId) {
                $query->where('dosen_id', $dosenId)
                    ->where('status', 'selesai');
            })
            ->count();

        // Ditolak TTD
        $ditolakTtd = Pengajuan::with(['user', 'jenisSurat', 'pengajuanTtd'])
            ->whereHas('pengajuanTtd', function ($query) use ($dosenId) {
                $query->where('dosen_id', $dosenId)
                    ->where('status', 'ditolak');
            })
            ->count();

        // Pengajuan TTD terbaru
        $recentPengajuan = Pengajuan::with(['user', 'jenisSurat', 'pengajuanTtd'])
            ->whereHas('pengajuanTtd', function ($query) use ($dosenId) {
                $query->where('dosen_id', $dosenId);
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dosen.dashboard', compact([
            'totalPengajuanTtd',
            'pendingTtd',
            'selesaiTtd',
            'ditolakTtd',
            'recentPengajuan'
        ]));
    }
}
