<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $total = Pengajuan::count();
        $pending = Pengajuan::where('status', 'pending')->count();
        $diterima = Pengajuan::where('status', 'diterima')->count();
        $ditolak = Pengajuan::where('status', 'ditolak')->count();

        $perBulan = Pengajuan::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('YEAR(created_at) as tahun'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        return $this->successResponse([
            'ringkasan' => [
                'total' => $total,
                'pending' => $pending,
                'diterima' => $diterima,
                'ditolak' => $ditolak,
            ],
            'per_bulan' => $perBulan,
        ]);
    }
}
