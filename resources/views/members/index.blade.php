@extends('members.layouts.app')

@section('content-member')

    <div class="card rounded-0 mt-3 mb-3">
        <div class="card-body">
            <h2>{{ __('profiles.avatar.name') }}</h2>
            <div class="members-picture">
                <form method="POST" action="{{ route('profile.picture.update') }}"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="file" onchange="this.form.submit()" name="image" accept=".jpg,.jpeg,.png"
                           class="form-control btn btn-primary btn-sm d-block px-4 w-100 my-2 rounded-0 @error('image') is-invalid @enderror"/>
                    @error('image')
                    <div id="image-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </form>
                <form method="POST" action="{{ route('profile.picture.destroy') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm d-block px-4 w-100 my-2 rounded-0">
                        {{ __('profiles.avatar.delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    @include('members.elements.email')
    @include('members.elements.password')
    @include('members.elements.discord')
    @include('profile.two-factor-authentication-form')

@endsection
