@extends('layouts.app')

@section('content')

    <div class="content_resources_show py-4 mb-5 mt-5 members">
        <div class="px-lg-0 mb-5 mt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                        <div class="card rounded-1">
                            <div class="card-body">

                                @if ($errors->any())
                                    <div>
                                        <div>{{ __('Whoops! Something went wrong.') }}</div>

                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                    <div>
                                        <label>{{ __('Email') }}</label>
                                        <input type="email" name="email"  class="form-control rounded-1" value="{{ old('email', $request->email) }}"
                                               required autofocus/>
                                    </div>

                                    <div class="mt-3">
                                        <label>{{ __('Password') }}</label>
                                        <input type="password" name="password" required  class="form-control rounded-1" autocomplete="new-password"/>
                                    </div>

                                    <div class="mt-3">
                                        <label>{{ __('Confirm Password') }}</label>
                                        <input type="password" name="password_confirmation" required  class="form-control rounded-1"
                                               autocomplete="new-password"/>
                                    </div>

                                    <div class="mt-3 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-success btn-sm rounded-1 d-block w-100 mt-2">
                                            {{ __('Reset Password') }}
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
