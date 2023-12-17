<div class="card rounded-1 mb-3">
    <div class="card-body">
        <h2>{{ __('profiles.banner.name') }}</h2>
        <div class="members-picture">
            <form method="POST" action="{{ route('profile.banner.update') }}"
                  enctype="multipart/form-data">
                @csrf
                <input type="file" onchange="this.form.submit()" name="image" accept=".jpg,.jpeg,.png"
                       class="form-control btn btn-primary btn-sm d-block px-4 w-100 my-2 rounded-1 @error('image') is-invalid @enderror"/>
                @error('image')
                <div id="image-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </form>
            <form method="POST" action="{{ route('profile.banner.destroy') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm d-block px-4 w-100 my-2 rounded-1">
                    {{ __('profiles.banner.delete') }}
                </button>
            </form>
        </div>
    </div>
</div>
