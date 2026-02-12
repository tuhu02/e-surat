<!DOCTYPE html>
<html lang="en" data-theme="lofi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Surat - Sistem Pengelolaan Surat Elektronik</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200 font-sans">
    <!-- Navbar -->
    <nav class="bg-base-100 shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTJ9sbQDkPtqKEwo-v23VFYmgg6uZu-6SNSbg&s" class="w-12 h-12" alt="Logo"/>
                    <span class="text-xl font-bold hidden sm:inline">E-Surat</span>
                </div>
                
                <!-- Auth Buttons -->
                <div class="flex gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-ghost">Sign In</a>
                        <a href="{{ route('register') }}" class="btn btn-neutral">Sign Up</a>
                    @else
                        @can('view.mahasiswa.dashboard')
                            <a href="/mahasiswa/dashboard" class="btn btn-primary">Dashboard</a>
                        
                        @elsecan('view.admin.dashboard')
                            <a href="/admin/dashboard" class="btn btn-primary">Dashboard</a>
                        @endcan
                        
                        <form method="POST" action="/logout" class="inline">
                            @csrf
                            <button type="submit" class="btn btn-ghost">Logout</button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
        <!-- Hero Section -->
        <div class="hero min-h-[60vh] bg-base-100 rounded-lg shadow-lg mb-16">
            <div class="hero-content text-center">
                <div class="max-w-3xl">
                    <h1 class="text-5xl font-bold mb-6">Selamat Datang di E-Surat</h1>
                    <p class="text-lg mb-8">
                        Sistem Pengelolaan Surat Elektronik yang memudahkan proses pengajuan, 
                        persetujuan, dan pengelolaan surat secara digital. Cepat, efisien, dan paperless.
                    </p>
                    
                    @guest
                        <div class="flex gap-4 justify-center">
                            <a href="{{ route('login') }}" class="btn btn-neutral btn-lg">
                                <i class="fa fa-sign-in-alt mr-2"></i>
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline btn-lg">
                                <i class="fa fa-user-plus mr-2"></i>
                                Daftar
                            </a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-center mb-12">Fitur Unggulan</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body items-center text-center">
                        <div class="text-5xl mb-4">
                            <i class="fa-solid fa-envelope-open-text"></i>
                        </div>
                        <h3 class="card-title">Pengajuan Surat Digital</h3>
                        <p>Ajukan berbagai jenis surat secara online tanpa perlu datang ke kantor</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body items-center text-center">
                        <div class="text-5xl mb-4">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <h3 class="card-title">Proses Cepat</h3>
                        <p>Tracking status surat real-time dan proses persetujuan yang lebih efisien</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body items-center text-center">
                        <div class="text-5xl mb-4">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h3 class="card-title">Aman & Terpercaya</h3>
                        <p>Data terenkripsi dan sistem yang dapat diandalkan untuk dokumen penting</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="stats stats-vertical lg:stats-horizontal shadow w-full mb-16">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <i class="fa-solid fa-users text-3xl"></i>
                </div>
                <div class="stat-title">Total Pengguna</div>
                <div class="stat-value text-primary">1.2K+</div>
                <div class="stat-desc">Mahasiswa dan Dosen</div>
            </div>
            
            <div class="stat">
                <div class="stat-figure text-secondary">
                    <i class="fa-solid fa-envelope text-3xl"></i>
                </div>
                <div class="stat-title">Surat Diproses</div>
                <div class="stat-value text-secondary">5.6K+</div>
                <div class="stat-desc">Sepanjang tahun ini</div>
            </div>
            
            <div class="stat">
                <div class="stat-figure text-accent">
                    <i class="fa-solid fa-check-circle text-3xl"></i>
                </div>
                <div class="stat-title">Tingkat Kepuasan</div>
                <div class="stat-value text-accent">98%</div>
                <div class="stat-desc">Rating pengguna</div>
            </div>
        </div>

        <!-- CTA Section -->
        @guest
            <div class="text-center bg-base-100 p-12 rounded-lg shadow-lg">
                <h2 class="text-3xl font-bold mb-4">Siap Memulai?</h2>
                <p class="text-lg mb-6">Bergabunglah dengan ribuan pengguna yang telah merasakan kemudahan E-Surat</p>
                <a href="{{ route('register') }}" class="btn btn-neutral btn-lg">
                    Daftar Sekarang
                    <i class="fa fa-arrow-right ml-2"></i>
                </a>
            </div>
        @endguest
    </main>

    <!-- Footer -->
    <footer class="footer footer-center p-5 bg-base-300 text-base-content text-xs mt-12">
        <div>
            <p>© {{ date('Y') }} E-Surat - Built with Laravel and ❤️</p>
        </div>
    </footer>
</body>
</html>