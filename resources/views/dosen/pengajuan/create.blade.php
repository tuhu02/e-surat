<x-layout>
    <x-slot:title>
        Upload Surat Selesai
    </x-slot:title>

    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.pengajuan.index') }}" class="text-blue-500 hover:underline mr-4">
                &larr; Kembali
            </a>
            <h1 class="font-bold text-2xl">Upload Surat Jadi</h1>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8 max-w-2xl mx-auto">
            <form action="{{ route('admin.pengajuan.store-upload', $pengajuan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-6 grid grid-cols-2 gap-4 p-4 bg-gray-50 rounded-md">
                    <div>
                        <p class="text-sm text-gray-500">Nama Pengaju</p>
                        <p class="font-semibold">{{ $pengajuan->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Jenis Surat</p>
                        <p class="font-semibold">{{ $pengajuan->jenisSurat->nama_surat }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="file_surat_jadi" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih File Surat (PDF, max 2MB)
                    </label>
                    <input type="file" 
                           name="file_surat_jadi" 
                           id="file_surat_jadi" 
                           accept=".pdf"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('file_surat_jadi') border-red-500 @enderror">
                    
                          @error('file_surat_jadi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition duration-200">
                        Simpan & Kirim Surat
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>