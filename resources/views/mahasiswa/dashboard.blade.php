<x-layout>
    <x-slot:title>
        Dashboard - Mahasiswa
    </x-slot:title>

    <div class="w-full">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-gray-600 mt-2">Kelola pengajuan surat online Anda dengan mudah</p>
        </div>

        <!-- Stats Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <!-- Total Pengajuan Card -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-semibold">Total Pengajuan</p>
                        <p class="text-4xl font-bold mt-2">{{ $totalPengajuan }}</p>
                    </div>
                    <div class="text-5xl opacity-25">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                </div>
            </div>

            <!-- Pending Card -->
            <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-semibold">Menunggu Proses</p>
                        <p class="text-4xl font-bold mt-2">{{ $pendingPengajuan }}</p>
                    </div>
                    <div class="text-5xl opacity-25">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                </div>
            </div>

            <!-- Approved Card -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-semibold">Diterima</p>
                        <p class="text-4xl font-bold mt-2">{{ $approvedPengajuan }}</p>
                    </div>
                    <div class="text-5xl opacity-25">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>
                </div>
            </div>

            <!-- Rejected Card -->
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-semibold">Ditolak</p>
                        <p class="text-4xl font-bold mt-2">{{ $rejectedPengajuan }}</p>
                    </div>
                    <div class="text-5xl opacity-25">
                        <i class="fa-solid fa-xmark-circle"></i>
                    </div>
                </div>
            </div>

            <!-- Pending TTD Card -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-semibold">Pending TTD</p>
                        <p class="text-4xl font-bold mt-2">{{ $pendingTtd }}</p>
                    </div>
                    <div class="text-5xl opacity-25">
                        <i class="fa-solid fa-pen"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Aksi Cepat</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('mahasiswa.meminta-surat') }}" class="flex items-center justify-center gap-3 p-4 border-2 border-blue-500 rounded-lg hover:bg-blue-50 transition">
                    <i class="fa-solid fa-plus text-blue-500 text-xl"></i>
                    <div class="text-left">
                        <p class="font-semibold text-gray-800">Ajukan Surat</p>
                        <p class="text-sm text-gray-600">Buat pengajuan baru</p>
                    </div>
                </a>

                <a href="{{ route('mahasiswa.histori.pengajuan') }}" class="flex items-center justify-center gap-3 p-4 border-2 border-green-500 rounded-lg hover:bg-green-50 transition">
                    <i class="fa-solid fa-clock-rotate-left text-green-500 text-xl"></i>
                    <div class="text-left">
                        <p class="font-semibold text-gray-800">Histori Surat</p>
                        <p class="text-sm text-gray-600">Lihat pengajuan Anda</p>
                    </div>
                </a>

                <a href="{{ route('mahasiswa.pengajuan.ttd.index') }}" class="flex items-center justify-center gap-3 p-4 border-2 border-purple-500 rounded-lg hover:bg-purple-50 transition">
                    <i class="fa-solid fa-signature text-purple-500 text-xl"></i>
                    <div class="text-left">
                        <p class="font-semibold text-gray-800">Pengajuan TTD</p>
                        <p class="text-sm text-gray-600">Ajukan untuk ditandatangani</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Requests Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Pengajuan Terbaru</h2>
                <a href="{{ route('mahasiswa.histori.pengajuan') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">
                    Lihat Semua →
                </a>
            </div>

            @if ($recentPengajuan->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="p-4 text-left font-semibold text-gray-700">#</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Jenis Surat</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Tanggal</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentPengajuan as $index => $item)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="p-4">{{ $index + 1 }}</td>
                            <td class="p-4 font-medium text-gray-800">{{ $item->jenisSurat->nama_surat ?? '-' }}</td>
                            <td class="p-4 text-gray-600">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="p-4">
                                @if ($item->status === 'pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                    <i class="fa-solid fa-hourglass-half"></i> Pending
                                </span>
                                @elseif ($item->status === 'diterima')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                    <i class="fa-solid fa-check"></i> Diterima
                                </span>
                                @elseif ($item->status === 'ditolak')
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                    <i class="fa-solid fa-xmark"></i> Ditolak
                                </span>
                                @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">
                                    {{ $item->status }}
                                </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-12">
                <div class="text-6xl text-gray-300 mb-4">
                    <i class="fa-solid fa-inbox"></i>
                </div>
                <p class="text-gray-600 text-lg mb-4">Belum ada pengajuan surat</p>
                <a href="{{ route('mahasiswa.meminta-surat') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                    Buat Pengajuan Pertama Anda →
                </a>
            </div>
            @endif
        </div>
    </div>

</x-layout>