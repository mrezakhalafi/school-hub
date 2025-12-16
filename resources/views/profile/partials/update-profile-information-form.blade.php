<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">{{ __('Update Profile Information') }}</h5>
    </div>
    <div class="card-body">
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autocomplete="name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-sm text-muted">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="btn btn-link p-0">
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

            <!-- Profile Image -->
            <div class="mb-3">
                <label for="profile_image" class="form-label">{{ __('Profile Image') }}</label>
                @if($user->profile_image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Current Profile" class="rounded-circle" width="100" height="100">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="remove_profile_image" id="remove_profile_image">
                            <label class="form-check-label" for="remove_profile_image">
                                {{ __('Remove current image') }}
                            </label>
                        </div>
                    </div>
                @endif
                <input type="file" name="profile_image" id="profile_image" class="form-control @error('profile_image') is-invalid @enderror" accept="image/*">
                @error('profile_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">{{ __('Save Profile') }}</button>
            </div>

            @if (session('status') === 'profile-updated')
                <div class="alert alert-success mt-3">
                    {{ __('Profile updated successfully!') }}
                </div>
            @endif
        </form>
    </div>
</div>
