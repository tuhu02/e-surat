<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePengajuanStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('approve.pengajuan')
            || $this->user()->can('reject.pengajuan')
            || $this->user()->can('view.permintaan.ttd');
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(['pending', 'diterima', 'ditolak', 'disetujui', 'ttd_ditolak'])],
            'file_surat_jadi' => 'nullable|file|mimes:pdf|max:2048',
            'keterangan' => 'nullable|string|max:500',
        ];
    }
}
