@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="container">
            <div class="row">
                <div class="col">
                    <p>{{ __('Whoops! Something went wrong.') }}</p>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="d-flex justify-content-center my-3">
                    <img src="{{ asset('images/bootstrap-5-logo.svg') }}" alt="Powered by Bootstrap 5" class="w-25 mx-auto px-3">
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ url('/two-factor-challenge') }}">
                            @csrf

                            {{--
                                Do not show both of these fields, together. It's recommended
                                that you only show one field at a time and use some logic
                                to toggle the visibility of each field
                            --}}

                            <p>
                                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                            </p>

                            <div class="mt-3">
                                <label>{{ __('Code') }}</label>
                                <input type="text" name="code" class="form-control" autofocus autocomplete="one-time-code" />
                            </div>

                            {{-- ** OR ** --}}

                            <p>
                                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                            </p>

                            <div class="mt-3">
                                <label>{{ __('Recovery Code') }}</label>
                                <input type="text" name="recovery_code" class="form-control" autocomplete="one-time-code" />
                            </div>

                            <div class="mt-3 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
