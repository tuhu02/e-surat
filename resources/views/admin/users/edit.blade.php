<x-layout>
    <x-slot:title>
        Manage - User
    </x-slot:title>

    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit User</h1>
            
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

            <form class="space-y-4" action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">
                        Nama
                    </label>
                    <input 
                        type="text"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        name="name"
                        value="{{ old('name', $user->name) }}"
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
                        value="{{ old('email', $user->email) }}"
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
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" 
                                {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">
                        Password Baru <span class="text-gray-500 text-xs">(Kosongkan jika tidak ingin mengubah)</span>
                    </label>
                    <input 
                        type="password"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        name="password"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">
                        Konfirmasi Password Baru
                    </label>
                    <input 
                        type="password"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        name="password_confirmation"
                    >
                </div>

                <div class="flex space-x-3 pt-4">
                    <button 
                        type="submit"
                        class="flex-1 py-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white font-semibold transition"
                    >
                        Update User
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
