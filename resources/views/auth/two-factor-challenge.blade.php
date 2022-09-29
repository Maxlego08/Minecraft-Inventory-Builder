@extends('layouts.app')

@section('content')
    <div class="content_resources_show py-4 mb-5 mt-5 members">
        <div class="px-lg-0 mb-5 mt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                        <div class="card rounded-0">
                            <div class="card-body">
                                <h2>{{ __('profiles.two_factor.title') }}</h2>
                                <form method="POST" action="{{ url('/two-factor-challenge') }}">
                                    @csrf

                                    {{--
                                        Do not show both of these fields, together. It's recommended
                                        that you only show one field at a time and use some logic
                                        to toggle the visibility of each field
                                    --}}

                                    <p>{{ __('profiles.two_factor.login.info') }}</p>

                                    <div class="mt-3 mb-4">
                                        <label for="code">{{ __('Code') }}</label>
                                        <input type="text" name="code" class="form-control rounded-0 @error('code') is-invalid @enderror" autofocus
                                               autocomplete="one-time-code" id="code"/>
                                        @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- ** OR ** --}}

                                    <p>{{ __('profiles.two_factor.login.info2') }}</p>

                                    <div class="mt-3">
                                        <label for="recovery_code">{{ __('Recovery Code') }}</label>
                                        <input type="text" name="recovery_code" class="form-control rounded-0 @error('recovery_code') is-invalid @enderror"
                                               autocomplete="one-time-code" id="recovery_code"/>
                                        @error('recovery_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mt-3 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary btn-sm rounded-0 d-block w-100 mt-2">
                                            {{ __('auth.login') }}
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
