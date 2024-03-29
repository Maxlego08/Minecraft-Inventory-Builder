@php use Illuminate\Support\Str; @endphp
@extends('resources.layouts.dashboard')

@section('title', __('resources.dashboard.payments.title'))

@section('dashboard-section')

    <div class="payment-table rounded-1">
        <h3><i class="bi bi-wallet2"></i> {{ __('resources.dashboard.payments.title') }}</h3>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th class="w-25">{{ __('resources.dashboard.payments.resource') }}</th>
                    <th>{{ __('resources.dashboard.payments.buyer') }}</th>
                    <th>{{ __('resources.dashboard.payments.transaction') }}</th>
                    <th>{{ __('resources.dashboard.payments.date') }}</th>
                    <th>{{ __('resources.dashboard.payments.earning') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                    <tr class="t-14">
                        <td>
                            <a href="{{ $payment->resource->link('description') }}">{{ Str::limit($payment->resource->name, 50) }}</a>
                        </td>
                        <td>{!! $payment->user->displayNameAndLink() !!}</td>
                        <td>{{ $payment->external_id }}</td>
                        <td>{{ simple_date($payment->created_at) }}</td>
                        <td>{{ formatPrice($payment->price, $payment->currency->currency) }}</td>
                        <td>
                            <a href="{{ route('resources.dashboard.payments.details', $payment) }}">{{ __('resources.dashboard.payments.details') }}</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {!! $payments->links('elements.pagination') !!}
            </div>
        </div>
    </div>

@endsection
