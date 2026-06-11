<x-layout>
    <x-slot:title>
        Histori Pengajuan TTD - Mahasiswa
    </x-slot:title>

    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Histori Pengajuan TTD</h1>
            <a href="{{ route('mahasiswa.pengajuan.ttd.index') }}" class="text-blue-600 hover:underline">
                Buat Pengajuan TTD Baru
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
                        <th class="p-3">Tanggal Pengajuan</th>
                        <th class="p-3">Status TTD</th>
                        <th class="p-3">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengajuanTtd as $index => $item)
                    <tr class="border-t">
                        <td class="p-3">{{ $index + 1 }}</td>
                        <td class="p-3">{{ $item->pengajuan->jenisSurat->nama_surat ?? '-' }}</td>
                        <td class="p-3">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                        <td id="status-{{ $item->id }}" class="p-3 capitalize">
                            <span class="px-2 py-1 rounded text-white text-xs font-semibold
                                    {{ $item->status === 'diterima' ? 'bg-green-500' : ($item->status === 'ditolak' ? 'bg-red-500' : 'bg-yellow-500') }}">
                                {{ $item->status ?? 'pending' }}
                            </span>
                        </td>
                        <td class="p-3">{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-500">
                            Belum ada pengajuan TTD.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script type="module">
        window.Echo.channel('pengajuan')
            .listen('.ttd-status-updated', (e) => {
                const statusEl = document.querySelector(`#status-${e.pengajuanTtd.id}`);
                if (statusEl) {
                    const statusClass = e.pengajuanTtd.status === 'diterima' ? 'bg-green-500' : 'bg-red-500';
                    statusEl.innerHTML = `
                        <span class="px-2 py-1 rounded text-white text-xs font-semibold ${statusClass}">
                            ${e.pengajuanTtd.status}
                        </span>
                    `;
                }
            });
    </script>
</x-layout>