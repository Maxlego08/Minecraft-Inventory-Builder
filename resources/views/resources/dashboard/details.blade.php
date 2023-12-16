@extends('resources.layouts.dashboard')

@section('title', __('resources.dashboard.payments.title'))

@section('dashboard-section')

    <div class="card rounded-1">
        <div class="card-body">
            <h3><i class="bi bi-cart"></i> {{ __('resources.dashboard.payments.transaction_details') }}</h3>
            <hr>
            <table class="w-100 table table-responsive">
                <thead>
                <tr>
                    <th class="w-75">{{ __('payment.resource') }}</th>
                    <th>{{ __('payment.price') }}</th>
                    <th>{{ __('payment.quantity') }}</th>
                    <th class="text-right">{{ __('payment.total') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr class="t-12">
                    <td>{{ $name }}</td>
                    <td>{{ formatPrice($contentPrice, $currency) }}</td>
                    <th>1</th>
                    <td>{{ formatPrice($contentPrice, $currency) }}</td>
                </tr>
                <tr class="t-14">
                    <td></td>
                    <td></td>
                    <th>{{ __('payment.subtotal') }}</th>
                    <td>{{ formatPrice($contentPrice, $currency) }}</td>
                </tr>
                @if(isset($gift))
                    <tr class="t-14" id="giftTable">
                        <td class="w-50"></td>
                        <td></td>
                        <th>{{ __('payment.gift.title') }}</th>
                        <td>-{{ formatPrice($giftReduction, $currency) }}
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
            <hr>
            <div class="d-flex justify-content-end me-4">
                <h4>{{ __('payment.total_end') }}</h4>
                <p class="ms-3 h4 text-info">{{ formatPrice($price, $currency) }}</p>
            </div>
        </div>
    </div>

@endsection
