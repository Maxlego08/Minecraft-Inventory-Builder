@extends('layouts.base')

@section('app')

    <div class="content_resources_add mb-5">
        <div class="container">
            <div class="px-0 px-lg-0">

                <div class="block_resources_add card my-4 rounded-1">
                    <div class="card-body px-4">
                        <div class="row align-items-center">
                            <div class="col-lg-7">
                                <h1 class="fw-bold fs-3">{{ __('resources.dashboard.title') }}</h1>
                                <p>{{ __('resources.dashboard.description') }}</p>
                            </div>
                            <div class="col-lg-4 offset-lg-1">
                                <a href="{{route('resources.create.index')}}"
                                   class="btn btn-primary btn-sm rounded-1 d-flex align-items-center justify-content-center"><i
                                        class="bi bi-plus-lg me-2 fs-6"></i>{{ __('resources.add') }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row my-4">
                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-md-6 col-lg-12">
                                <div class="card mb-3 rounded-1">
                                    <div class="card-body">
                                        <h2 class="text-center fs-5 fw-bold"> {{ __('resources.dashboard.title') }}</h2>
                                        <ul class="list-group">
                                            <li class="d-flex justify-content-between align-items-cente">
                                                <a class="text-decoration-none" href="{{ route('resources.dashboard.index') }}"><i class="bi bi-globe"></i> {{ __('resources.dashboard.overview.title') }}</a>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-cente">
                                                <a class="text-decoration-none" href="{{ route('resources.dashboard.resources') }}"><i class="bi bi-list-task"></i> {{ __('resources.dashboard.products.title') }}</a>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-cente">
                                                <a class="text-decoration-none" href="{{ route('resources.dashboard.payments') }}"><i class="bi bi-wallet2"></i> {{ __('resources.dashboard.payments.title') }}</a>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-cente">
                                                <a class="text-decoration-none" href="{{ route('resources.dashboard.gift.index') }}"><i class="bi bi-gift"></i> {{ __('resources.dashboard.gifts.title') }}</a>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-cente">
                                                <a class="text-decoration-none" href="{{ route('resources.dashboard.discord.index') }}"><i class="bi bi-discord"></i> {{ __('resources.dashboard.discord.title') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        @yield('dashboard-section')
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
