@extends('layouts.base')

@section('app')

    <div class="content_resources_add mb-5">
        <div class="container">
            <div class="px-0 px-lg-0">

                <div class="block_resources_add card my-4 rounded-1">
                    <div class="card-body px-4">
                        <div class="row align-items-center">
                            <div class="col-lg-7">
                                <h1 class="fw-bold fs-3">{{ __('resources.purchased.title') }}</h1>
                                <p>{{ __('resources.purchased.description') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row my-4">
                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-md-6 col-lg-12 members">
                                <div class="card mb-3 rounded-1">
                                    <div class="card-body px-4">
                                        <h2 class="text-center fs-5 fw-bold"> {{ __('resources.purchased.title') }}</h2>
                                        <nav>
                                            <ul class="ps-0">
                                                <li class="list-group-item mb-2">
                                                    <a href="{{ route('resources.purchased') }}"><i
                                                            class="bi bi-globe"></i> {{ __('resources.dashboard.overview.title') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
