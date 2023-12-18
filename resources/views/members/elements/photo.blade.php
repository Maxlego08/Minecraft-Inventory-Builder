<div class="card rounded-1 mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <div class="d-flex justify-content-between">
                    <h2>{{ __('profiles.avatar.name') }}</h2>
                    <form method="POST" action="{{ route('profile.picture.destroy') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm d-block px-4 w-100 my-2 rounded-1">
                            {{ __('profiles.avatar.delete') }}
                        </button>
                    </form>
                </div>
                <div class="members-picture">
                    <form method="POST" action="{{ route('profile.picture.update') }}" class="w-100"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="file" onchange="this.form.submit()" name="image" @if(user()->role->isPro()) accept=".jpg,.jpeg,.png,.gif" @else accept=".jpg,.jpeg,.png" @endif
                               class="form-control btn btn-primary btn-sm d-block px-4 w-100 my-2 rounded-1 @error('image') is-invalid @enderror"/>
                        @error('image')
                        <div id="image-error" class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </form>
                </div>
            </div>
            <div class="col-6">
                <div class="d-flex justify-content-between">
                    <h2>{{ __('profiles.banner.name') }}</h2>
                    @if(user()->role->isPro())
                        <form method="POST" action="{{ route('profile.banner.destroy') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm d-block px-4 w-100 my-2 rounded-1">
                                {{ __('profiles.banner.delete') }}
                            </button>
                        </form>
                    @endif
                </div>
                <div class="members-picture">
                    @if(user()->role->isPro())
                        <form method="POST" action="{{ route('profile.banner.update') }}" class="w-100"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="file" onchange="this.form.submit()" name="image" accept=".jpg,.jpeg,.png"
                                   class="form-control btn btn-primary btn-sm d-block px-4 w-100 my-2 rounded-1 @error('image') is-invalid @enderror"/>
                            @error('image')
                            <div id="image-error" class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </form>
                    @else
                        <div
                            class="btn btn-sm btn-primary disabled cursor-disabled w-100 mt-2">{{ __('profile.banner.permission') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
