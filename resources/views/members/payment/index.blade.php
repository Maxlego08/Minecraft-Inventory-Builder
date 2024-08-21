@extends('members.layouts.app')

@section('title', __('payment.title'))

@section('content-member')

    <div class="card rounded-1 mb-3">
        <div class="card-body">
            <h2 class="d-flex justify-content-between">{{ __('payment.stripe.title') }}
                <form action="{{ route('profile.payment.delete.stripe') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="btn btn-danger btn-sm rounded-1 d-block">{{ __('messages.delete') }}</button>
                </form>
            </h2>
            <form action="{{ route('profile.payment.store.stripe') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="sk_live" class="form-label">{{ __('payment.stripe.sk_live') }}</label>
                    <input type="text" class="form-control rounded-1 @error('sk_live') is-invalid @enderror"
                           id="sk_live" placeholder="sk_live_..."
                           name="sk_live" required>
                    @error('sk_live')
                    <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="pk_live" class="form-label">{{ __('payment.stripe.pk_live') }}</label>
                    <input type="text" class="form-control rounded-1 @error('pk_live') is-invalid @enderror"
                           id="pk_live" placeholder="pk_live..."
                           name="pk_live" value="{{ old('pk_live', $paymentInfo->pk_live ?? '') }}" required>
                    @error('pk_live')
                    <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small> {!! __('payment.stripe.info') !!}</small>
                </div>

                <button type="submit" class="btn btn-primary btn-sm rounded-1 d-block w-100 mt-2">
                    {{ __('messages.save') }}
                </button>
            </form>
        </div>
    </div>

    <div class="card rounded-1 mb-3">
        <div class="card-body">
            <h2 class="d-flex justify-content-between">{{ __('payment.paypal.title') }}
                <form action="{{ route('profile.payment.delete.paypal') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="btn btn-danger btn-sm rounded-1 d-block">{{ __('messages.delete') }}</button>
                </form>
            </h2>
            <form action="{{ route('profile.payment.store.paypal') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="paypal_email" class="form-label">{{ __('payment.paypal.email') }}</label>
                    <input type="text" class="form-control rounded-1 @error('paypal_email') is-invalid @enderror"
                           id="paypal_email" placeholder="example@groupez.dev"
                           name="paypal_email" value="{{ old('paypal_email', $paymentInfo->paypal_email ?? '') }}"
                           required>
                    @error('paypal_email')
                    <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small>{{ __('payment.paypal.info') }}</small>
                </div>

                <button type="submit" class="btn btn-primary btn-sm rounded-1 d-block w-100 mt-2">
                    {{ __('messages.save') }}
                </button>
            </form>
        </div>
    </div>

    <div class="card rounded-1 mb-3">
        <div class="card-body">
            <h2 class="d-flex justify-content-between">{{ __('payment.currency.title') }}</h2>
            <form action="{{ route('profile.payment.store.currency') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <select class="form-select rounded-1" name="currency" id="currency" required>
                        @foreach($currencies as $currentCurrency)
                            <option value="{{ $currentCurrency->id }}"
                                    @if ($currency == $currentCurrency->id) selected @endif>{{ strtoupper($currentCurrency->currency) }} {{ $currentCurrency->icon }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-sm rounded-1 d-block w-100 mt-2">
                    {{ __('messages.save') }}
                </button>
            </form>
        </div>
    </div>

@endsection
