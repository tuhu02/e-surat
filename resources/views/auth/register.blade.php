<!DOCTYPE html>
<html lang="en" data-theme="lofi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - E-Surat</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200 font-sans">
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
        <div class="hero min-h-[calc(100vh-20rem)]">
            <div class="hero-content flex-col">
                <div class="card w-96 bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h1 class="text-3xl font-bold text-center mb-6">Create Account</h1>

                        <form method="POST" action="{{ route('register.submit') }}">
                            @csrf

                            <!-- Name -->
                            <label class="floating-label mb-6">
                                <input type="text"
                                       name="name"
                                       placeholder="John Doe"
                                       value="{{ old('name') }}"
                                       class="input input-bordered @error('name') input-error @enderror"
                                       required>
                                <span>Name</span>
                            </label>
                            @error('name')
                                <div class="label -mt-4 mb-2">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </div>
                            @enderror

                            <!-- Email -->
                            <label class="floating-label mb-6">
                                <input type="email"
                                       name="email"
                                       placeholder="mail@example.com"
                                       value="{{ old('email') }}"
                                       class="input input-bordered @error('email') input-error @enderror"
                                       required>
                                <span>Email</span>
                            </label>
                            @error('email')
                                <div class="label -mt-4 mb-2">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </div>
                            @enderror

                            <!-- Password -->
                            <label class="floating-label mb-6">
                                <input type="password"
                                       name="password"
                                       placeholder="••••••••"
                                       class="input input-bordered @error('password') input-error @enderror"
                                       required>
                                <span>Password</span>
                            </label>
                            @error('password')
                                <div class="label -mt-4 mb-2">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </div>
                            @enderror

                            <!-- Password Confirmation -->
                            <label class="floating-label mb-6">
                                <input type="password"
                                       name="password_confirmation"
                                       placeholder="••••••••"
                                       class="input input-bordered"
                                       required>
                                <span>Confirm Password</span>
                            </label>

                            <!-- Submit Button -->
                            <div class="form-control mt-8">
                                <button type="submit" class="btn btn-neutral btn-sm w-full">
                                    Register
                                </button>
                            </div>
                        </form>

                        <div class="divider">OR</div>
                        <p class="text-center text-sm">
                            Already have an account?
                            <a href="/login" class="link link-primary">Sign in</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>