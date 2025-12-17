<x-guest-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #f5f7fa 0%, #e4edf9 100%);">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px; background: linear-gradient(135deg, #10b981, #06b6d4); border-radius: 50%;">
                                <svg class="text-white" style="width: 32px; height: 32px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <h2 class="h3 mb-2 fw-bold">Create Account</h2>
                            <p class="text-muted">Join us today to get started</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-medium">{{ __('Full Name') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input id="name"
                                           class="form-control form-control-lg @error('name') is-invalid @enderror"
                                           type="text"
                                           name="name"
                                           :value="old('name')"
                                           required
                                           autofocus
                                           autocomplete="name"
                                           placeholder="Enter your full name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-medium">{{ __('Email Address') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="email"
                                           class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           type="email"
                                           name="email"
                                           :value="old('email')"
                                           required
                                           autocomplete="username"
                                           placeholder="Enter your email address">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="form-label fw-medium">{{ __('Password') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password"
                                           class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           type="password"
                                           name="password"
                                           required
                                           autocomplete="new-password"
                                           placeholder="Create a strong password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-medium">{{ __('Confirm Password') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password_confirmation"
                                           class="form-control form-control-lg"
                                           type="password"
                                           name="password_confirmation"
                                           required
                                           autocomplete="new-password"
                                           placeholder="Confirm your password">
                                </div>
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-lg btn-primary shadow-sm" style="background: linear-gradient(135deg, #10b981, #06b6d4); border: none; padding: 12px 0; font-weight: 600; letter-spacing: 0.5px;">
                                    {{ __('Register') }}
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="mb-0">{{ __('Already registered?') }} <a href="{{ route('login') }}" class="text-decoration-none">Sign in</a></p>
                            </div>

                            <div class="text-center mt-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-grow-1 border-top"></div>
                                    <span class="mx-3 text-muted small">Or register with</span>
                                    <div class="flex-grow-1 border-top"></div>
                                </div>

                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="#" class="btn btn-outline-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; border-radius: 50%;">
                                        <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12.24 10.285V14.4h6.806c-.275 1.765-2.056 5.174-6.806 5.174-4.095 0-7.439-3.389-7.439-7.574s3.345-7.574 7.439-7.574c2.33 0 3.891.989 4.785 1.849l3.254-3.138C18.189 1.186 15.479 0 12.24 0c-6.635 0-12 5.365-12 12s5.365 12 12 12c6.926 0 11.52-4.869 11.52-11.726 0-.788-.085-1.39-.189-1.989H12.24z"/>
                                        </svg>
                                    </a>
                                    <a href="#" class="btn btn-outline-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; border-radius: 50%;">
                                        <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
