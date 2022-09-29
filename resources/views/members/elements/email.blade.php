<div class="card rounded-0 mb-3">
    <div class="card-body">
        <h2>{{ __('messages.email') }}</h2>
        <form action="{{ route('profile.email') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('profiles.email.new') }}</label>
                <input type="email" class="form-control rounded-0 @error('email') is-invalid @enderror" id="email"
                       name="email" value="{{ user()->email }}" required>
                @error('email')
                <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-sm rounded-0 d-block w-100 mt-2">
                {{ __('profiles.email.change') }}
            </button>
        </form>
    </div>
</div>
