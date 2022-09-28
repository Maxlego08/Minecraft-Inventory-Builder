<div class="card rounded-0 mb-3">
    <div class="card-body">
        <h2>Changer d’adresse e-mail</h2>
        <form action="{{ route('profile.email') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Nouvelle adresse e-mail</label>
                <input type="email" class="form-control rounded-0 @error('email') is-invalid @enderror" id="email"
                       name="email" value="{{ user()->email }}">
                @error('email')
                <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-sm rounded-0 d-block w-100 mt-2">
                Changer d’adresse e-mail
            </button>
        </form>
    </div>
</div>
