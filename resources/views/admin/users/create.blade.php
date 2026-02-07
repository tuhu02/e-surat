<x-layout>
    <x-slot:title>
        Manage - User
    </x-slot:title>

    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Membuat Akun User</h1>
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">Oops!</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="space-y-4" action="{{ route('admin.create.users.submit') }}" method="POST">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">
                        Nama
                    </label>
                    <input 
                        type="text"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        name="name"
                        value="{{ old('name') }}"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">
                        Email
                    </label>
                    <input 
                        type="email"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        name="email"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">
                        Role
                    </label>
                    <select 
                        name="role"
                        class="w-full px-3 py-2 border rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">
                        Password
                    </label>
                    <input 
                        type="password"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        name="password"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">
                        Konfirmasi Password
                    </label>
                    <input 
                        type="password"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        name="password_confirmation"
                        required
                    >
                </div>

                <div class="flex space-x-3 pt-4">
                    <button 
                        type="submit"
                        class="flex-1 py-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white font-semibold transition"
                    >
                        Buat User
                    </button>
                    <a 
                        href="{{ route('admin.users.index') }}"
                        class="flex-1 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white font-semibold text-center transition"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layout>