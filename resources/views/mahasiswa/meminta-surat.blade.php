
<x-layout>
    <x-slot:title>
        Pengajuan Surat - Mahasiswa
    </x-slot:title>

    <div class="max-w-4xl mx-auto">
    <h1 class="text-3xl text-center font-bold mt-8 text-green-900">
        PENGAJUAN SURAT ONLINE
    </h1>
    <p class="text-center text-gray-600 mt-2">
        <i>Isi form pengajuan dibawah:</i>
    </p>

    @if(session('success'))
        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mt-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mahasiswa.meminta-surat.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-2 gap-6 mt-10">
            <div>
                <label class="block mb-1 font-medium">NIM *</label>
                <input name="nim" type="text" value="{{ auth()->user()->id }}" class="w-full border p-2 rounded" readonly/>
            </div>

            <div>
                <label class="block mb-1 font-medium">Nama *</label>
                <input 
                    type="text"
                    value="{{ auth()->user()->name }}"
                    class="w-full border p-2 rounded bg-gray-100"
                    readonly
                />
            </div>

            <div class="col-span-2">
                <label class="block mb-1 font-medium">Pilih Jenis Surat *</label>
                <select name="jenis_surat_id" class="w-full border p-2 rounded" required>
                    <option value="">-- Pilih Jenis Surat --</option>
                    @foreach ($jenisSurat as $item)
                        <option value="{{ $item->id }}" {{ old('jenis_surat_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_surat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-2">
                <label class="block mb-1 font-medium">Berkas Pendukung</label>

                <div class="flex items-center gap-4">
                    <label class="cursor-pointer px-4 py-2 bg-green-700 text-white  text-sm rounded">
                        Pilih Berkas
                        <input type="file" name="berkas" id="fileInput" class="hidden" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    </label>
                    <span id="fileName" class="text-gray-500 text-sm">
                        Belum ada file dipilih
                    </span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Format: PDF, DOC, DOCX, JPG, PNG (Max: 2MB)</p>
            </div>
        </div>
        <button type="submit" class="w-full mt-6 bg-green-700 hover:bg-green-800 text-white p-2 rounded">Submit Pengajuan</button>
    </form>
</div>


<script>
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');

    fileInput.addEventListener('change', () => {
        fileName.textContent = fileInput.files.length
            ? fileInput.files[0].name
            : 'Belum ada file dipilih';
    });
</script>



</x-layout>