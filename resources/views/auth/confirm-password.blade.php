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

    <div class="content_resources_show py-4 mb-5 mt-5 members">
        <div class="px-lg-0 mb-5 mt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                        <div class="card rounded-0">
                            <div class="card-body">
                                <form method="POST" action="{{ route('password.confirm') }}">
                                    @csrf

                                    <div class="mt-3">
                                        <label for="password">{{ __('messages.password') }}</label>
                                        <input type="password" name="password" class="form-control rounded-0" required
                                               autocomplete="current-password"/>
                                    </div>

                                    <div class="mt-3 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-success btn-lg rounded-0">
                                            {{ __('profiles.password.confirmed') }}
                                        </button>
                                    </div>

                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="d-inline-block mt-3">
                                            {{ __('profiles.password.forgot') }}
                                        </a>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
