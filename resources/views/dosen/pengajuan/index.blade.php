
<x-layout>
    <x-slot:title>
        Pengajuan - Dosen
    </x-slot:title>

    <div class="w-full">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Daftar Pengajuan TTD</h1>
            <p class="text-gray-600 mt-2">Kelola pengajuan penanda tangan surat mahasiswa</p>
        </div>

        @if($pengajuan->count() > 0)
            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Mahasiswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Surat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pengajuan as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->nim }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $item->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $item->jenisSurat->nama_surat ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->pengajuanTtd)
                                    @switch($item->pengajuanTtd->status)
                                        @case('pending')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                            @break
                                        @case('selesai')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Selesai
                                            </span>
                                            @break
                                        @case('ditolak')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Ditolak
                                            </span>
                                            @break
                                    @endswitch
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $item->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ asset('storage/' . $item->berkas) }}" 
                                        target="_blank" 
                                    class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 transition">
                                        Lihat
                                    </a>
                                    @if($item->pengajuanTtd && $item->pengajuanTtd->status === 'pending')
                                        <a href="#" class="inline-flex items-center px-3 py-2 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 transition">
                                            Setujui
                                        </a>
                                        <a href="#" class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition">
                                            Tolak
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada pengajuan</h3>
                <p class="mt-2 text-gray-600">Anda tidak memiliki pengajuan TTD yang perlu ditandatangani saat ini.</p>
            </div>
        @endif
    </div>
</x-layout>