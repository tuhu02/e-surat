
<x-layout>
    <x-slot:title>
        Dashboard - Admin
    </x-slot:title>

    <div class="w-full">
        <h1 class="text-3xl text-center font-bold mt-8 text-green-900">PENGAJUAN SURAT ONLINE</h1>
        <p class="text-center text-gray-600 mt-2"><i>Isi form pengajuan dibawah: </i></p>
        
        <div class="grid grid-cols-2 gap-3 mt-10">
            <div>
                <h1>NIM *</h1>
                <input class="w-96" />
            </div>
            <div>
                <h1>Nama *</h1>
                <input class="w-96" />
            </div>

            <div>
                <h1>No HP *</h1>
                <input class="w-96" />
            </div>
            <div>
                <h1>Pilih Jenis Surat *</h1>
                <input class="w-96" />
            </div>

            <div class="col-span-2">
                <h1>Berkas Pendukung</h1>
                <input type="file" class="w-full p-2"/>
            </div>
        </div>
    </div>
</x-layout>