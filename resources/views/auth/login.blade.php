@extends('layouts.base')

@section('title', 'GroupeZ')

@section('app')
    <div class="content_resources_show py-5 mb-5">
        <div class="px-3 px-lg-0">
            <div class="container">
                <div class="card mb-3">
                    <div class="card-body">
                        <h1 class="fw-bold fs-5 mb-0">Se connecter</h1>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas egestas nibh
                            at ante luctus
                            convallis.</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label for="email" class="form-label ms-3">{{ __('Email') }}</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email">
                                        @error('email')
                                        <div id="password-error"
                                             class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label ms-3">{{ __('Password') }}</label>
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror" id="password"
                                               name="password">
                                        @error('password')
                                        <div id="password-error"
                                             class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="my-4">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember-me-checkbox">
                                        <label class="form-check-label" for="remember-me-checkbox">
                                            {{ __('Remember me') }}
                                        </label>
                                    </div>
                                    <button type="submit"
                                            class="btn btn-primary rounded-4 d-block w-100 mt-5">{{ __('Login') }}</button>
                                </div>
                            </div>
                        </form>
                        <a href="{{ route('password.request') }}"
                           class="text-muted w-100 text-center my-3 d-block">{{ __('Forgot your password?') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
