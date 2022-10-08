@extends('layouts.app')

@section('content')

    <div class="content_resources_show py-5 mb-5 members">
        <div class="px-lg-0">
            <div class="container">
                <div class="main-row-2">
                    <div class="main-col-1">
                        <div class="rounded-0 card">
                            <div class="card-header d-flex justify-content-center align-items-center">

                                <img src="{{ user()->getProfilePhotoUrlAttribute() }}" height="50" width="50"
                                     alt="{{ user()->name }}" class="rounded-2">
                                <span class="d-lg-block ms-2">{{ user()->name }}</span>

                            </div>
                            <div class="card-body px-4">
                                <nav>
                                    <ul class="ps-0">
                                        <li class="list-group-item mb-2">
                                            <a href="#">{{ __('profiles.nav.account') }}</a>
                                        </li>
                                        <li class="list-group-item mb-2">
                                            <a href="{{ route('profile.alerts') }}">{{ __('profiles.nav.alerts') }}</a>
                                        </li>
                                        <li class="list-group-item mb-2">
                                            <a href="#">{{ __('profiles.nav.conversations') }}</a>
                                        </li>
                                        <li class="list-group-item mb-2">
                                            <a href="#">{{ __('profiles.nav.resources.your') }}</a>
                                        </li>
                                        <li class="list-group-item mb-2">
                                            <a href="#">{{ __('profiles.nav.resources.add') }}</a>
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
