@extends('layouts.base')

@section('title', __('auth.register.title'))

@section('app')
    <div class="content_resources_show py-5 mb-5">
        <div class="px-3 px-lg-0">
            <div class="container">
                <div class="card mb-3 rounded-1">
                    <div class="card-body">
                        <h1 class="fw-bold fs-5 mb-0">{{ __('auth.register.title') }}</h1>
                        <p class="mb-0">{{ __('auth.register.info') }}</p>
                    </div>
                </div>

                <div class="card rounded-1">
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">

                            @csrf

                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">{{ __('Username') }}</label>
                                        <input type="text"
                                               class="form-control rounded-1 @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name') }}" required
                                               autocomplete="off">
                                        @error('name')
                                        <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">{{ __('Email') }}</label>
                                        <input type="email"
                                               class="form-control rounded-1 @error('email') is-invalid @enderror"
                                               id="email" name="email" value="{{ old('email') }}" required
                                               autocomplete="email" autofocus>
                                        @error('email')
                                        <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">{{ __('Password') }}</label>
                                        <input type="password"
                                               class="form-control rounded-1 @error('password') is-invalid @enderror"
                                               id="password" name="password" required autocomplete="password">
                                        @error('password')
                                        <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_confirmation"
                                               class="form-label">{{ __('Confirm Password') }}</label>
                                        <input type="password"
                                               class="form-control rounded-1 @error('password_confirmation') is-invalid @enderror"
                                               id="password_confirmation" name="password_confirmation" required
                                               autocomplete="password">
                                        @error('password_confirmation')
                                        <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="my-4">
                                        <input class="form-check-input @error('terms') is-invalid @enderror"
                                               type="checkbox" name="terms" id="terms" required>
                                        <label class="form-check-label"
                                               for="terms">{!! __('auth.register.term') !!}</label>
                                        @error('terms')
                                        <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit"
                                            class="btn btn-primary rounded-1 d-block w-100">{{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
