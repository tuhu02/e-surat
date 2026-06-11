<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\PengajuanTtd;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Get stats
        $totalPengajuan = Pengajuan::where('user_id', $userId)->count();
        $pendingPengajuan = Pengajuan::where('user_id', $userId)->where('status', 'pending')->count();
        $approvedPengajuan = Pengajuan::where('user_id', $userId)->where('status', 'diterima')->count();
        $rejectedPengajuan = Pengajuan::where('user_id', $userId)->where('status', 'ditolak')->count();
        $pendingTtd = PengajuanTtd::where('user_id', $userId)->where('status', 'pending')->count();

        // Get recent requests
        $recentPengajuan = Pengajuan::with('jenisSurat')
            ->where('user_id', $userId)
            ->latest()
            ->limit(5)
            ->get();

        return view('mahasiswa.dashboard', compact(
            'totalPengajuan',
            'pendingPengajuan',
            'approvedPengajuan',
            'rejectedPengajuan',
            'pendingTtd',
            'recentPengajuan'
        ));
    }
}
