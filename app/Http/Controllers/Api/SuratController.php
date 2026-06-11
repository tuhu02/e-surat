<?php

namespace App\Http\Controllers\Api;

use App\Events\PengajuanCreated;
use App\Events\PengajuanStatusUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePengajuanRequest;
use App\Http\Requests\Api\UpdatePengajuanStatusRequest;
use App\Http\Resources\PengajuanResource;
use App\Models\Pengajuan;
use App\Models\PengajuanTtd;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuratController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $query = Pengajuan::with(['user', 'jenisSurat', 'pengajuanTtd']);

        $user = $request->user();

        if ($user->hasRole('mahasiswa')) {
            $query->where('user_id', $user->id);
        } elseif ($user->hasRole('dosen')) {
            $query->whereHas('pengajuanTtd', fn ($q) => $q->where('dosen_id', $user->id));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_surat_id')) {
            $query->where('jenis_surat_id', $request->jenis_surat_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                    ->orWhereHas('jenisSurat', fn ($jq) => $jq->where('nama_surat', 'like', "%{$search}%"))
                    ->orWhereHas('user', fn ($uq) => $uq->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $pengajuan = $query->latest()->paginate($request->integer('per_page', 10));

        return $this->successResponse([
            'items' => PengajuanResource::collection($pengajuan),
            'meta' => [
                'current_page' => $pengajuan->currentPage(),
                'last_page' => $pengajuan->lastPage(),
                'per_page' => $pengajuan->perPage(),
                'total' => $pengajuan->total(),
            ],
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $pengajuan = Pengajuan::with(['user', 'jenisSurat', 'pengajuanTtd'])->findOrFail($id);

        if (! $this->canAccessPengajuan($request->user(), $pengajuan)) {
            return $this->errorResponse('Anda tidak memiliki akses ke data ini.', 403);
        }

        return $this->successResponse(new PengajuanResource($pengajuan));
    }

    public function ajukan(StorePengajuanRequest $request): JsonResponse
    {
        $berkasPath = $request->file('file_pendukung')->store('pengajuan', 'public');

        $pengajuan = Pengajuan::create([
            'nim' => $request->nim,
            'user_id' => $request->user()->id,
            'jenis_surat_id' => $request->jenis_surat_id,
            'berkas' => $berkasPath,
            'status' => 'pending',
        ]);

        $pengajuan->load(['user', 'jenisSurat']);

        event(new PengajuanCreated($pengajuan));

        return $this->successResponse(
            new PengajuanResource($pengajuan),
            'Pengajuan surat berhasil dikirim.',
            201
        );
    }

    public function updateStatus(UpdatePengajuanStatusRequest $request, int $id): JsonResponse
    {
        $pengajuan = Pengajuan::with(['user', 'jenisSurat', 'pengajuanTtd'])->findOrFail($id);
        $user = $request->user();
        $status = $request->status;

        try {
            DB::beginTransaction();

            if ($user->hasRole('dosen') && in_array($status, ['disetujui', 'ttd_ditolak'])) {
                $pengajuanTtd = PengajuanTtd::where('pengajuan_id', $pengajuan->id)
                    ->where('dosen_id', $user->id)
                    ->firstOrFail();

                $pengajuanTtd->update([
                    'status' => $status === 'disetujui' ? 'disetujui' : 'ditolak',
                    'keterangan' => $request->keterangan ?? $pengajuanTtd->keterangan,
                ]);
            } elseif ($user->can('approve.pengajuan') || $user->can('reject.pengajuan')) {
                if ($status === 'diterima' && $request->hasFile('file_surat_jadi')) {
                    $path = $request->file('file_surat_jadi')->store('surat_jadi', 'public');
                    $pengajuan->update([
                        'file_surat_jadi' => $path,
                        'status' => 'diterima',
                    ]);
                } elseif ($status === 'ditolak') {
                    $pengajuan->update(['status' => 'ditolak']);
                } else {
                    $pengajuan->update(['status' => $status]);
                }
            } else {
                return $this->errorResponse('Anda tidak memiliki izin untuk mengubah status surat ini.', 403);
            }

            $pengajuan->refresh()->load(['user', 'jenisSurat', 'pengajuanTtd']);

            broadcast(new PengajuanStatusUpdated($pengajuan));

            DB::commit();

            return $this->successResponse(
                new PengajuanResource($pengajuan),
                'Status surat berhasil diperbarui.'
            );
        } catch (\Throwable $e) {
            DB::rollBack();

            return $this->errorResponse('Gagal memperbarui status surat: '.$e->getMessage(), 500);
        }
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        if (! $request->user()->hasRole('admin') && ! $request->user()->hasRole('super-admin')) {
            return $this->errorResponse('Anda tidak memiliki izin untuk menghapus surat.', 403);
        }

        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->status !== 'pending') {
            return $this->errorResponse('Hanya surat dengan status pending yang dapat dihapus.', 422);
        }

        $pengajuan->delete();

        return $this->successResponse(null, 'Surat berhasil dihapus.');
    }

    private function canAccessPengajuan($user, Pengajuan $pengajuan): bool
    {
        if ($user->hasRole('admin') || $user->hasRole('super-admin')) {
            return true;
        }

        if ($user->hasRole('mahasiswa')) {
            return $pengajuan->user_id === $user->id;
        }

        if ($user->hasRole('dosen')) {
            return $pengajuan->pengajuanTtd?->dosen_id === $user->id;
        }

        return false;
    }
}
