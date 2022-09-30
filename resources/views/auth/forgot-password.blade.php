@extends('layouts.app')

@section('content')

    <div class="content_resources_show py-4 mb-5 mt-5 members">
        <div class="px-lg-0 mb-5 mt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                        <div class="card rounded-0">
                            <div class="card-body">

                                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </symbol>
                                </svg>

                                @error('email')
                                <div class="alert alert-success d-flex align-items-center rounded-0" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                         aria-label="Success:">
                                        <use xlink:href="#check-circle-fill"/>
                                    </svg>
                                    <div>
                                        {{ __('auth.forgot.send') }}
                                    </div>
                                </div>
                                @enderror
                                @if (session('status'))
                                    <div class="alert alert-success d-flex align-items-center rounded-0" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                             aria-label="Success:">
                                            <use xlink:href="#check-circle-fill"/>
                                        </svg>
                                        <div>
                                            {{ __('auth.forgot.send') }}
                                        </div>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <p>{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>

                                    <div class="mt-3">
                                        <label for="email">{{ __('Email') }}</label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                               class="form-control rounded-0"
                                               required autofocus/>
                                    </div>

                                    <div class="mt-3 d-flex justify-content-center">
                                        <button type="submit"
                                                class="btn btn-success btn-sm rounded-0 d-block w-100 mt-2">
                                            {{ __('auth.forgot.link') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
