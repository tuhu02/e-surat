<!DOCTYPE html>
<html lang="en" data-theme="lofi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin</title>
    <link rel="preconnect" href="<https://fonts.bunny.net>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex bg-base-200 font-sans">
    <nav class="w-64 h-screen bg-base-100 flex flex-col sticky top-0">
        <div class="p-4 flex justify-center">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTJ9sbQDkPtqKEwo-v23VFYmgg6uZu-6SNSbg&s" class="w-20"/>
        </div>

        <div class="flex-1 px-4 space-y-2 mt-6">
            <!-- MENU ADMIN -->
            
            @can('view.admin.dashboard')
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-2 rounded hover:bg-base-200">
                <i class="fa fa-home w-5"></i> Dashboard
            </a>
            @endcan

            @can('view.mahasiswa.dashboard')
            <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-3 p-2 rounded hover:bg-base-200">
                <i class="fa fa-home w-5"></i> Dashboard
            </a>
            @endcan

            @can('read.user')
            <a href="/admin/users/" class="flex items-center gap-3 p-2 rounded hover:bg-base-200">
                <i class="fa fa-user w-5"></i> User
            </a>
            @endcan
            @can('read.role')
            <a href="/admin/roles/" class="flex items-center gap-3 p-2 rounded hover:bg-base-200">
                <i class="fa fa-user-shield w-5"></i> Role
            </a>
            @endcan
            @can('read.pengajuan')
            <a href="/admin/pengajuan/" class="flex items-center gap-3 p-2 rounded hover:bg-base-200">
                <i class="fa-solid fa-envelope w-5"></i> Surat
            </a>
            @endcan

            <!-- MENU MAHASISWA -->
            @can('create.pengajuan')
            <a href="/mahasiswa/meminta-surat" class="flex items-center gap-3 p-2 rounded hover:bg-base-200">
                <i class="fa-solid fa-envelope w-5"></i> Meminta Surat
            </a>
            <a href="/mahasiswa/histori-pengajuan" class="flex items-center gap-3 p-2 rounded hover:bg-base-200">
                <i class="fa-solid fa-clock-rotate-left w-5"></i> Histori Pengajuan Surat
            </a>
            @endcan

            <a href="/mahasiswa/pengajuan-ttd" class="flex items-center gap-3 p-2 rounded hover:bg-base-200">
                    <i class="fa-solid fa-signature w-5"></i> Pengajuan TTD
            </a>
        </div>

        <!-- LOGOUT DI BAWAH -->
        <div class="p-4 mt-auto">
            @auth
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm bg-gray-500 text-white w-full">Logout</button>
                </form>
            @else
                <a href="/login" class="btn btn-ghost btn-sm w-full">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm w-full mt-2">Sign Up</a>
            @endauth
        </div>
    </nav>

        
    <!-- Success Toast -->
    @if (session('success'))
        <div class="toast toast-top toast-center">
            <div class="alert alert-success animate-fade-out">
                <svg xmlns="<http://www.w3.org/2000/svg>" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- CONTENT AREA -->
    <div class="flex-1 flex flex-col">
        
        <main class="flex-1 container mx-auto px-4 py-8">
            {{ $slot }}
        </main>

        <footer class="footer footer-center p-5 bg-base-300 text-base-content text-xs">
            <div>
                <p>© {{ date('Y') }} Tuhu - Built with Laravel and ❤️</p>
            </div>
        </footer>

    </div>
</body>
</html>