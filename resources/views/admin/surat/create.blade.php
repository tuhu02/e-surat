<x-layout>
    <x-slot:title>
        Manage - User
    </x-slot:title>

    <div class="container mx-auto px-4 py-6">
        <h1 class="font-bold text-2xl mb-10">Buatkan Surat</h1>
        <div class="bg-white rounded-lg shadow-md p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
        </div>
    </div>
</x-layout>