@extends('resources.layouts.users')

@section('title', __('resources.purchased.title'))

@section('content')

    <div class="payment-table rounded-1">
        <h3><i class="bi bi-wallet2"></i> {{ __('resources.dashboard.payments.title') }}</h3>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th class="w-25">{{ __('resources.dashboard.payments.resource') }}</th>
                    <th>{{ __('resources.dashboard.payments.date') }}</th>
                    <th>{{ __('resources.dashboard.payments.price') }}</th>
                    <th>{{ __('resources.dashboard.payments.transaction') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($accesses as $access)
                    <tr class="t-14">
                        <td>
                            <a href="{{ $access->resource->link('description') }}">{{ \Illuminate\Support\Str::limit($access->resource->name, 50) }}</a>
                        </td>
                        <td>
                            {{ format_date($access->created_at, true) }}
                        </td>
                        <td>
                            {{ $access->getPrice() }}
                        </td>
                        <td>
                            @if($access->payment_id != null)
                                {{ $access->payment->external_id }}
                            @endif
                        </td>
                        <td>
                            @if($access->payment_id != null)
                                <a href="{{ route('resources.purchased.payment', $access->payment) }}">{{ __('resources.dashboard.payments.details') }}</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
