@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="display-6 fw-bold text-primary">Edit Profile</h1>
                    <p class="text-muted">Update your personal information and account settings</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back
                    </a>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-xl-8">
                    <div class="card shadow-lg border-0 mb-4">
                        <div class="card-header bg-white border-0 py-4 px-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-user-edit text-primary me-2"></i>
                                Update Profile Information
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>

                            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('patch')

                                <div class="mb-4">
                                    <label for="name" class="form-label fw-medium">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" name="name" id="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autocomplete="name" placeholder="Enter your full name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="form-label fw-medium">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email" id="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username" placeholder="Enter your email address">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                            <div class="mt-2">
                                                <p class="text-sm text-muted">
                                                    {{ __('Your email address is unverified.') }}

                                                    <button form="send-verification" class="btn btn-link p-0 text-decoration-none">
                                                        {{ __('Click here to re-send the verification email.') }}
                                                    </button>
                                                </p>

                                                @if (session('status') === 'verification-link-sent')
                                                    <p class="mt-2 text-success">
                                                        {{ __('A new verification link has been sent to your email address.') }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Profile Image -->
                                <div class="mb-4">
                                    <label for="profile_image" class="form-label fw-medium">Profile Image</label>
                                    @if($user->profile_image)
                                        <div class="mt-2 d-flex align-items-center">
                                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Current Profile" class="rounded-circle me-3" width="100" height="100">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remove_profile_image" id="remove_profile_image">
                                                <label class="form-check-label" for="remove_profile_image">
                                                    {{ __('Remove current image') }}
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="mt-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-image"></i>
                                            </span>
                                            <input type="file" name="profile_image" id="profile_image" class="form-control form-control-lg @error('profile_image') is-invalid @enderror" accept="image/*">
                                            @error('profile_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary px-4 py-2">
                                        <i class="fas fa-save me-2"></i> Save Profile
                                    </button>
                                </div>

                                @if (session('status') === 'profile-updated')
                                    <div class="alert alert-success mt-4">
                                        <i class="fas fa-check-circle me-2"></i> {{ __('Profile updated successfully!') }}
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>

                    <div class="card shadow-lg border-0 mb-4">
                        <div class="card-header bg-white border-0 py-4 px-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-key text-success me-2"></i>
                                Update Password
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted mb-4">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>

                            <form method="post" action="{{ route('password.update') }}">
                                @csrf
                                @method('put')

                                <div class="mb-4">
                                    <label for="update_password_current_password" class="form-label fw-medium">Current Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" name="current_password" id="update_password_current_password" class="form-control form-control-lg @error('current_password') is-invalid @enderror" autocomplete="current-password" placeholder="Enter your current password">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="update_password_password" class="form-label fw-medium">New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" name="password" id="update_password_password" class="form-control form-control-lg @error('password') is-invalid @enderror" autocomplete="new-password" placeholder="Enter your new password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="update_password_password_confirmation" class="form-label fw-medium">Confirm New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" name="password_confirmation" id="update_password_password_confirmation" class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" autocomplete="new-password" placeholder="Confirm your new password">
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary px-4 py-2">
                                        <i class="fas fa-save me-2"></i> Save Password
                                    </button>
                                </div>

                                @if (session('status') === 'password-updated')
                                    <div class="alert alert-success mt-4">
                                        <i class="fas fa-check-circle me-2"></i> {{ __('Password updated successfully!') }}
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>

                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-white border-0 py-4 px-4">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-trash-alt text-danger me-2"></i>
                                Delete Account
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted mb-4">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                            </p>

                            <!-- Button to trigger modal -->
                            <button type="button" class="btn btn-danger px-4 py-2" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
                                <i class="fas fa-trash-alt me-2"></i> Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="confirmUserDeletionModalLabel">{{ __('Confirm Account Deletion') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}</p>

                    <form method="post" action="{{ route('profile.destroy') }}" class="mt-4" id="deleteAccountForm">
                        @csrf
                        @method('delete')

                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium">{{ __('Password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="password" id="password" class="form-control form-control-lg @error('password', 'userDeletion') is-invalid @enderror" placeholder="{{ __('Password') }}">
                                @error('password', 'userDeletion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" form="deleteAccountForm" class="btn btn-danger px-4">{{ __('Delete Account') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
