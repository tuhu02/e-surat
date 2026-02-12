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

            <form class="space-y-4" action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">
                        Role
                    </label>
                    <input 
                        type="text"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        name="name"
                        value="{{ old('name', $role->name) }}"
                        required
                    >
                </div>

                <div class="flex space-x-3 pt-4">
                    <button 
                        type="submit"
                        class="flex-1 py-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white font-semibold transition"
                    >
                        Update Role
                    </button>
                    <a 
                        href="{{ route('admin.roles.index') }}"
                        class="flex-1 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white font-semibold text-center transition"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layout>
