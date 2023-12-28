@extends('layouts.app')

@section('title', __('upgrade.title'))

@section('content')

    <div class="content_home pb-5 mt-5 mb-5">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 270"
             fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M0 90.5202L107 97.5434C213 105.347 427 120.173 640 105.347C853 90.5202 1067 45.2601 1280 22.6301C1493 0 1707 0 1813 0H1920V270H1813C1707 270 1493 270 1280 270C1067 270 853 270 640 270C427 270 213 270 107 270H0V90.5202Z"
                  fill="#1A1A2E"/>
        </svg>
        <article class="home_abonnement bg-blue-800">
            <div class="container">
                <div class="text-center block_title">
                    <h2>{{ __('upgrade.title') }}</h2>
                    <p>{{ __('upgrade.description') }}</p>
                </div>
                <div class="px-3 px-lg-0">
                    <div class="row g-5 row-cols-lg-3">
                        @include('members.elements.premium.member')
                        @include('members.elements.premium.premium')
                        @include('members.elements.premium.pro')
                    </div>
                </div>
            </div>
        </article>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 270"
             fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M1920 179.48L1813 172.457C1707 164.653 1493 149.827 1280 164.653C1067 179.48 853 224.74 640 247.37C427 270 213 270 107 270L0 270L2.36041e-05 7.62889e-05L107 8.56431e-05C213 9.49099e-05 427 0.000113618 640 0.000132239C853 0.000150861 1067 0.000169569 1280 0.00018819C1493 0.000206811 1707 0.00022552 1813 0.000234786L1920 0.000244141L1920 179.48Z"
                  fill="#1A1A2E"/>
        </svg>
    </div>

@endsection
