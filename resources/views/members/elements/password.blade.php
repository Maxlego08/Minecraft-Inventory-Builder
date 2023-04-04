<div class="card rounded-0 mb-3">
    <div class="card-body">
        <h2>{{ __('messages.password') }}</h2>
        <form action="{{ route('profile.password') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="old_password" class="form-label">{{ __('profiles.password.exist') }}</label>
                <input type="password" class="form-control rounded-0 @error('old_password') is-invalid @enderror"
                       id="password" name="old_password" required>
                @error('old_password')
                <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('profiles.password.new') }}</label>
                <input type="password" class="form-control rounded-0 @error('password') is-invalid @enderror"
                       id="password" name="password" required>
                @error('password')
                <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">{{ __('profiles.password.confirm') }}</label>
                <input type="password"
                       class="form-control rounded-0 @error('password_confirmation') is-invalid @enderror"
                       id="password_confirmation" name="password_confirmation" required>
                @error('password_confirmation')
                <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-sm rounded-0 d-block w-100 mt-2">
                {{ __('profiles.password.change') }}
            </button>
        </form>
    </div>
</div>
