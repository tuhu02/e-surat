<x-layout>
    <x-slot:title>
        Manajemen Pengajuan Surat
    </x-slot:title>

    <div class="container mx-auto px-4 py-6">
        <h1 class="font-bold text-2xl mb-10">Pengajuan Surat</h1>
        <div class="bg-white rounded-lg shadow-md p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                No
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                NIM
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Nama
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Surat Pengajuan
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Surat Pendukung
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-center">
                        @forelse ($pengajuan as $index => $dataPengajuan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $dataPengajuan->nim }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $dataPengajuan->user->name }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $dataPengajuan->jenisSurat->nama_surat }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @if($dataPengajuan->berkas)
                                        <a href="{{ asset('storage/' . $dataPengajuan->berkas) }}" 
                                        target="_blank" 
                                        class="inline-flex items-center px-3 py-1 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-medium rounded transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Lihat Berkas
                                        </a>
                                    @else
                                        <span class="text-red-400">Tidak ada file</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $dataPengajuan->status }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <a 
                                        href="{{ route('admin.pengajuan.create', $dataPengajuan->id) }}"
                                        class="inline-block bg-blue-500 hover:bg-blue-600 py-1.5 px-3.5 text-white rounded-lg text-sm transition"
                                    >
                                        Upload Surat
                                    </a>

                                    <form 
                                        action="{{ route('admin.pengajuan.decline', $dataPengajuan->id) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Yakin decline pengajuan ini?')"
                                    >
                                        @csrf
                                        @method('PATCH') <button 
                                            type="submit"
                                            class="bg-red-500 hover:bg-red-600 py-1.5 px-3.5 text-white rounded-lg text-sm transition"
                                        >
                                            Decline
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500">
                                    Tidak ada data permintaan surat
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>