<x-layout>
    <x-slot:title>
        Histori Pengajuan - Mahasiswa
    </x-slot:title>

    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Histori Pengajuan</h1>
            <a href="{{ route('mahasiswa.meminta-surat') }}" class="text-blue-600 hover:underline">
                Buat Pengajuan Baru
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">Jenis Surat</th>
                        <th class="p-3">Berkas Pengajuan</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Surat Jadi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengajuan as $index => $item)
                        <tr class="border-t">
                            <td class="p-3">{{ $index + 1 }}</td>
                            <td class="p-3">{{ $item->jenisSurat->nama_surat ?? '-' }}</td>
                            <td class="p-3">
                                @if ($item->berkas)
                                    <a class="text-blue-600 hover:underline" href="{{ asset('storage/' . $item->berkas) }}" target="_blank">
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td id="status-{{ $item->id }}" class="p-3 capitalize">{{ $item->status ?? 'pending' }}</td>
                            <td class="p-3">
                                @if ($item->file_surat_jadi)
                                    <a class="text-green-700 hover:underline" href="{{ asset('storage/' . $item->file_surat_jadi) }}" target="_blank">
                                        Unduh
                                    </a>
                                @else
                                    <span class="text-gray-500">Belum tersedia</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">
                                Belum ada pengajuan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script type="module">
    window.Echo.channel('pengajuan')
        .listen('.status-updated', (e) => {
            console.log('Data baru:', e.pengajuan);

            const jenis = e.pengajuan.jenisSurat ? e.pengajuan.jenisSurat.nama_surat : 'Tidak tersedia';

            const statusEl = document.querySelector(`#status-${e.pengajuan.id}`);
            if(statusEl) {
                statusEl.innerText = e.pengajuan.status + ' (' + jenis + ')';
            }
        });
</script>

</x-layout>
