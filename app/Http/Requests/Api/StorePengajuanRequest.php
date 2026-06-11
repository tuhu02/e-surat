<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StorePengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create.pengajuan');
    }

    public function rules(): array
    {
        return [
            'nim' => 'required|string|max:255',
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'file_pendukung' => 'required|file|mimes:pdf|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'file_pendukung.required' => 'Berkas pendukung wajib diunggah.',
            'file_pendukung.mimes' => 'Berkas pendukung harus berformat PDF.',
            'file_pendukung.max' => 'Ukuran berkas pendukung maksimal 2MB.',
        ];
    }
}
