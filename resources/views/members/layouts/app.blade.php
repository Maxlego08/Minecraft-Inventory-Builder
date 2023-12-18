@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="content_resources_show py-5 mb-5 members">
        <div class="px-lg-0">
            <div class="container">
                <div class="main-row-2">
                    <div class="main-col-1">
                        <div class="rounded-1 card">
                            <div class="card-header d-flex justify-content-center align-items-center">

                                <img src="{{ user()->getProfilePhotoUrlAttribute() }}" height="50" width="50"
                                     alt="{{ user()->name }}" class="rounded-2">
                                <span class="d-lg-block ms-2">{{ user()->name }}</span>

                            </div>
                            <div class="card-body px-4">
                                <nav>
                                    <ul class="ps-0">
                                        <li class="list-group-item mb-2">
                                            <a href="{{ route('resources.author', ['slug' => user()->slug(), 'user' => user()]) }}"><i class="bi bi-people-fill"></i> {{ __('profiles.nav.account') }}</a>
                                        </li>
                                        <li class="list-group-item mb-2">
                                            <a href="{{ route('profile.index') }}"><i class="bi bi-person-fill"></i> {{ __('profiles.nav.details') }}</a>
                                        </li>
                                        <li class="list-group-item mb-2">
                                            <a href="{{ route('profile.alerts') }}"><i class="bi bi-bell"></i> {{ __('profiles.nav.alerts') }}</a>
                                        </li>
                                        <li class="list-group-item mb-2">
                                            <a href="{{ route('profile.conversations.index') }}"><i class="bi bi-chat-dots"></i> {{ __('profiles.nav.conversations') }}</a>
                                        </li>
                                        <li class="list-group-item mb-2">
                                            <a href="{{ route('profile.images.index') }}"><i class="bi bi-card-image"></i> {{ __('profiles.nav.images') }}</a>
                                        </li>
                                        <li class="list-group-item mb-2">
                                            <a href="{{ user()->getProfileUrl() }}"><i class="bi bi-list-task"></i> {{ __('profiles.nav.resources.your') }}</a>
                                        </li>
                                        <li class="list-group-item mb-2">
                                            <a href="{{ route('resources.create.index') }}"><i class="bi bi-plus-lg"></i> {{ __('profiles.nav.resources.add') }}</a>
                                        </li>
                                        <li class="list-group-item mb-2">
                                            <a href="{{ route('profile.payment.index') }}"><i class="bi bi-currency-euro"></i> {{ __('payment.nav') }}</a>
                                        </li>
                                        <li class="list-group-item mb-2">
                                            <a href="{{ route('profile.colors.index') }}"><i class="bi bi-palette"></i> {{ __('profiles.nav.color') }}</a>
                                        </li>
                                    </ul>
                                </nav>

                            </div>
                        </div>

                    </div>
                    <div class="main-col-2">

                        <div class="members-banner">
                            <div class="members-banner-wrapper">
                                <div class="general-info">
                                    <h2 class="general-info-name">{{ __('profiles.dashboard') }}</h2>
                                </div>
                                <p class="description">{{ __('profiles.description') }}</p>
                            </div>
                        </div>

                        @yield('content-member')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
