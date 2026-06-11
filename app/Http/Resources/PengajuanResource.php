<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PengajuanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nim' => $this->nim,
            'status' => $this->status,
            'berkas' => $this->berkas ? Storage::disk('public')->url($this->berkas) : null,
            'file_surat_jadi' => $this->file_surat_jadi ? Storage::disk('public')->url($this->file_surat_jadi) : null,
            'nomor_surat' => $this->generateNomorSurat(),
            'user' => $this->whenLoaded('user', fn () => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ]),
            'jenis_surat' => $this->whenLoaded('jenisSurat', fn () => [
                'id' => $this->jenisSurat->id,
                'nama_surat' => $this->jenisSurat->nama_surat,
            ]),
            'pengajuan_ttd' => $this->whenLoaded('pengajuanTtd', fn () => $this->pengajuanTtd ? [
                'id' => $this->pengajuanTtd->id,
                'status' => $this->pengajuanTtd->status,
                'keterangan' => $this->pengajuanTtd->keterangan,
                'dosen_id' => $this->pengajuanTtd->dosen_id,
            ] : null),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }

    private function generateNomorSurat(): string
    {
        $tahun = $this->created_at?->format('Y') ?? date('Y');
        $bulan = $this->created_at?->format('m') ?? date('m');

        return sprintf('%03d/ES/%s/%s', $this->id, $bulan, $tahun);
    }
}
