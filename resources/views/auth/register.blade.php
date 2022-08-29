@extends('layouts.base')

@section('title', 'GroupeZ')

@section('app')
    <div class="content_resources_show py-5 mb-5">
        <div class="px-3 px-lg-0">
            <div class="container">
                <div class="card mb-3">
                    <div class="card-body">
                        <h1 class="fw-bold fs-5 mb-0">Se connecter</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas egestas nibh
                            at ante luctus
                            convallis.</p>
                    </div>
                </div>

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

                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">

                            @csrf

                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label ms-3">{{ __('Name') }}</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label ms-3">{{ __('Email') }}</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label ms-3">{{ __('Password') }}</label>
                                        <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label ms-3">{{ __('Confirm Password') }}</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                    <div class="my-4">
                                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            J’accepte les <a href="#">conditions générales d’utilisation </a>et <a
                                                href="#">la charte de confidentialité</a> du GroupeZ Marketplace.</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary rounded-4 d-block w-100 mt-5">{{ __('Register') }}
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
