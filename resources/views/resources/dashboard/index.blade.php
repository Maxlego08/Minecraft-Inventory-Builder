@extends('resources.layouts.dashboard')

@section('title', __('resources.dashboard.overview.title'))

@section('dashboard-section')

    <div class="row">

        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card shadow h-100 py-2 rounded-1">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div
                                class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('resources.dashboard.overview.resources') }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $resources }}</div>
                        </div>
                        <div class="col-auto h3">
                            <i class="bi bi-list-task"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card shadow h-100 py-2 rounded-1">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div
                                class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('resources.dashboard.overview.payments') }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $payments }}</div>
                        </div>
                        <div class="col-auto h3">
                            <i class="bi bi-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card shadow h-100 py-2 rounded-1">
                <div class="card-body">
                    <div class="no-gutters align-items-center">
                        <div class="col mr-2">
                            <div
                                class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('resources.dashboard.overview.earn') }}
                            </div>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ formatPrice($earnMoney, $currency)  }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card shadow h-100 py-2 rounded-1">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div
                                class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('resources.dashboard.overview.download') }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $download }}</div>
                        </div>
                        <div class="col-auto h3">
                            <i class="bi bi-download"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
