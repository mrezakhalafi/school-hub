<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">{{ __('Update Password') }}</h5>
    </div>
    <div class="card-body">
        <p class="text-muted mb-4">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
                <input type="password" name="current_password" id="update_password_current_password" class="form-control @error('current_password') is-invalid @enderror" autocomplete="current-password">
                @error('current_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
                <input type="password" name="password" id="update_password_password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <input type="password" name="password_confirmation" id="update_password_password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" autocomplete="new-password">
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">{{ __('Save Password') }}</button>
            </div>

            @if (session('status') === 'password-updated')
                <div class="alert alert-success mt-3">
                    {{ __('Password updated successfully!') }}
                </div>
            @endif
        </form>
    </div>
</div>
