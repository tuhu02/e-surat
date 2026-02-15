
<x-layout>
    <x-slot:title>
        Pengajuan TTD
    </x-slot:title>

    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl text-center font-bold mt-8 text-green-900">PENGAJUAN TTD</h1>
        <p class="text-center text-gray-600 mt-2">
            <i>Pilih surat yang sudah diajukan, lalu kirim permintaan tanda tangan.</i>
        </p>

        <div class="mt-8 bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Form Pengajuan TTD</h2>

            <form action="{{ route('mahasiswa.pengajuan.ttd.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block mb-1 font-medium">Surat Diajukan *</label>
                    <select name="pengajuan_id" class="w-full border p-2 rounded" required>
                        <option value="">-- Pilih Surat --</option>
                        @forelse($pengajuan as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->jenisSurat->nama_surat }}
                            </option>
                        @empty
                            <option value="" disabled>Tidak ada pengajuan surat</option>
                        @endforelse
                    </select>
                    <input type="hidden" name="id-pengajuan" value="{{ $item->id ?? '' }}">
                    <p class="text-xs text-gray-500 mt-1">
                        Surat yang tersedia berasal dari pengajuan yang sudah kamu buat.
                    </p>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Catatan (opsional)</label>
                    <textarea name="catatan" rows="3" class="w-full border p-2 rounded" placeholder="Contoh: Mohon tanda tangan sebelum tanggal 20"></textarea>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Berkas Pendukung (opsional)</label>
                    <input type="file" class="w-full border p-2 rounded" />
                    <p class="text-xs text-gray-500 mt-1">Format: PDF, DOC, DOCX, JPG, PNG (Max: 2MB)</p>
                </div>

                <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white py-2 rounded">
                    Kirim Pengajuan TTD
                </button>
            </form>
        </div>

        <div class="mt-6 p-4 bg-gray-50 border rounded text-sm text-gray-700">
            <span class="font-medium">Info:</span> Jika belum ada surat yang tersedia, silakan lakukan pengajuan terlebih dahulu. Surat akan ditampilkan setelah pengajuan disetujui.
        </div>
    </div>
</x-layout>