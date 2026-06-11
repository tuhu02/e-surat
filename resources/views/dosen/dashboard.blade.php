<x-layout>
    <x-slot:title>
        Dashboard - Dosen
    </x-slot:title>

    <div class="w-full">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-gray-600 mt-2">Kelola pengajuan penanda tangan surat mahasiswa</p>
        </div>

        <!-- Stats Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Total Pengajuan TTD Card -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-semibold">Total Pengajuan TTD</p>
                        <p class="text-4xl font-bold mt-2">{{ $totalPengajuanTtd }}</p>
                    </div>
                    <div class="text-5xl opacity-25">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                </div>
            </div>

            <!-- Pending TTD Card -->
            <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-semibold">Menunggu Tanda Tangan</p>
                        <p class="text-4xl font-bold mt-2">{{ $pendingTtd }}</p>
                    </div>
                    <div class="text-5xl opacity-25">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                </div>
            </div>

            <!-- Selesai TTD Card -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-semibold">Sudah Ditandatangani</p>
                        <p class="text-4xl font-bold mt-2">{{ $selesaiTtd }}</p>
                    </div>
                    <div class="text-5xl opacity-25">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>
                </div>
            </div>

            <!-- Ditolak TTD Card -->
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-semibold">Ditolak</p>
                        <p class="text-4xl font-bold mt-2">{{ $ditolakTtd }}</p>
                    </div>
                    <div class="text-5xl opacity-25">
                        <i class="fa-solid fa-xmark-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Aksi Cepat</h2>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                <a href="{{ route('dosen.pengajuan.index') }}" class="flex items-center justify-center gap-3 p-4 border-2 border-blue-500 rounded-lg hover:bg-blue-50 transition">
                    <i class="fa-solid fa-list-check text-blue-500 text-xl"></i>
                    <div class="text-left">
                        <p class="font-semibold text-gray-800">Lihat Permintaan TTD</p>
                        <p class="text-sm text-gray-600">Kelola pengajuan penanda tangan surat</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Requests Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Pengajuan TTD Terbaru</h2>
                <a href="{{ route('dosen.pengajuan.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">
                    Lihat Semua →
                </a>
            </div>

            @if ($recentPengajuan->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="p-4 text-left font-semibold text-gray-700">#</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Nama Mahasiswa</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Jenis Surat</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Tanggal</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentPengajuan as $index => $item)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="p-4">{{ $index + 1 }}</td>
                            <td class="p-4 font-medium text-gray-800">{{ $item->user->name ?? '-' }}</td>
                            <td class="p-4 text-gray-600">{{ $item->jenisSurat->nama_surat ?? '-' }}</td>
                            <td class="p-4 text-gray-600">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="p-4">
                                @if ($item->pengajuanTtd && $item->pengajuanTtd->status === 'pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                    <i class="fa-solid fa-hourglass-half"></i> Pending
                                </span>
                                @elseif ($item->pengajuanTtd && $item->pengajuanTtd->status === 'selesai')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                    <i class="fa-solid fa-check"></i> Selesai
                                </span>
                                @elseif ($item->pengajuanTtd && $item->pengajuanTtd->status === 'ditolak')
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                    <i class="fa-solid fa-xmark"></i> Ditolak
                                </span>
                                @endif
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
                <p class="mt-2 text-gray-600">Anda tidak memiliki pengajuan TTD saat ini.</p>
            </div>
            @endif
        </div>
    </div>
</x-layout>