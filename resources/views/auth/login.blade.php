<x-guest-layout>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="padding: 1rem 0;">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="/">
                <span class="text-primary">{{ config('app.name', 'School-Hub') }}</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="/#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="/#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="/#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="/#contact">Contact</a>
                    </li>
                    @guest
                        <li class="nav-item ms-2">
                            <a href="{{ route('register') }}" class="btn btn-primary rounded-5 px-4 py-2">Get Started</a>
                        </li>
                    @else
                        <li class="nav-item ms-2">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-5 px-4 py-2">Dashboard</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <div class="card shadow-lg border-0"
                    style="background: linear-gradient(135deg, #f5f7fa 0%, #e4edf9 100%);">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="mx-auto d-flex align-items-center justify-content-center mb-3"
                                style="width: 64px; height: 64px; background: linear-gradient(135deg, #3b82f6, #8b5cf6); border-radius: 50%;">
                                <svg class="text-white" style="width: 32px; height: 32px;" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h2 class="h3 mb-2 fw-bold">Welcome Back</h2>
                            <p class="text-muted">Sign in to your account to continue</p>
                        </div>

                        <!-- Session Status -->
                        <x-auth-session-status class="alert alert-info mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-medium">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text px-4">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="email"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        type="email" name="email" :value="old('email')" required autofocus
                                        autocomplete="username" placeholder="Enter your email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="password" class="form-label fw-medium">Password</label>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}"
                                            class="text-decoration-none small">Forgot password?</a>
                                    @endif
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text px-4">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        type="password" name="password" required autocomplete="current-password"
                                        placeholder="Enter your password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                    <label class="form-check-label" for="remember_me">
                                        Remember me
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-lg btn-primary shadow-sm"
                                    style="background: linear-gradient(135deg, #3b82f6, #8b5cf6); border: none; padding: 12px 0; font-weight: 600; letter-spacing: 0.5px;">
                                    Sign In
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="mb-0">Don't have an account? <a href="{{ route('register') }}"
                                        class="text-decoration-none">Register now</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
