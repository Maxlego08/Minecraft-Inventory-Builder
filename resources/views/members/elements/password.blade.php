<div class="card rounded-0 mb-3">
    <div class="card-body">
        <h2>Changer de mot de passe</h2>
        <form action="{{ route('profile.password') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="old_password" class="form-label">Votre mot de passe</label>
                <input type="password" class="form-control rounded-0 @error('old_password') is-invalid @enderror"
                       id="password" name="old_password">
                @error('old_password')
                <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Nouveau mot de passe</label>
                <input type="password" class="form-control rounded-0 @error('password') is-invalid @enderror"
                       id="password" name="password">
                @error('password')
                <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmation du nouveau
                    mot de passe</label>
                <input type="password"
                       class="form-control rounded-0 @error('password_confirmation') is-invalid @enderror"
                       id="password_confirmation" name="password_confirmation">
                @error('password_confirmation')
                <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-sm rounded-0 d-block w-100 mt-2">
                Changer votre mot de passe
            </button>
        </form>
    </div>
</div>
