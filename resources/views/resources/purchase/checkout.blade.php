@extends('layouts.base')

@section('title', "Purchase")

@section('app')

    <div class="container my-5">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('resources.purchase.session', ['resource' => $resource->id]) }}">
            <div class="card rounded-1 mb-3">
                <div class="card-body">
                    <div class="row">
                        @csrf
                        <div class="col-md-7">
                            <h2 class="mb-4"><i class="bi bi-person-fill"></i> {{ __('payment.details') }}</h2>
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('messages.name') }}</label>
                                <input type="text" class="form-control rounded-1 cursor-disabled" id="name"
                                       value="{{ user()->name }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('messages.email') }}</label>
                                <input type="email" class="form-control rounded-1  cursor-disabled" id="email"
                                       value="{{ user()->email }}" disabled>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">{{ __('payment.how') }}</label>
                                @if(isset($resource->user->paymentInfo->sk_live))
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod[]" id="stripe" value="stripe"
                                               checked>
                                        <label class="form-check-label" for="stripe">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-stripe" viewBox="0 0 16 16">
                                                <path
                                                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.226 5.385c-.584 0-.937.164-.937.593 0 .468.607.674 1.36.93 1.228.415 2.844.963 2.851 2.993C11.5 11.868 9.924 13 7.63 13a7.662 7.662 0 0 1-3.009-.626V9.758c.926.506 2.095.88 3.01.88.617 0 1.058-.165 1.058-.671 0-.518-.658-.755-1.453-1.041C6.026 8.49 4.5 7.94 4.5 6.11 4.5 4.165 5.988 3 8.226 3a7.29 7.29 0 0 1 2.734.505v2.583c-.838-.45-1.896-.703-2.734-.703Z"/>
                                            </svg>
                                            Stripe (Credit/Debit Card)</label>
                                    </div>
                                @endif
                                @if(isset($resource->user->paymentInfo->paypal_email))
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod[]" id="paypal" value="paypal"
                                               @if(!isset($resource->user->paymentInfo->sk_live)) checked @endif>
                                        <label class="form-check-label" for="paypal"><i class="bi bi-paypal"></i>
                                            Paypal</label>
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">I agree to the terms & conditions of this
                                    purchase.</label>
                                @error('terms')
                                <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm rounded-1 d-block w-100 mt-4">
                                {{ __('payment.button') }}
                            </button>
                        </div>
                        <div class="col-md-5">
                            <div class="p-4">
                                <h3 class="mb-4"><i class="bi bi-cart"></i> {{ __('payment.order') }}</h3>
                                <hr>
                                <table class="w-100">
                                    <thead>
                                    <tr>
                                        <th class="w-50">{{ __('payment.resource') }}</th>
                                        <th>{{ __('payment.price') }}</th>
                                        <th>{{ __('payment.quantity') }}</th>
                                        <th class="text-right">{{ __('payment.total') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="t-12">
                                        <td>{{ $resource->name }}</td>
                                        <td>{{ resourcePrice($resource) }}</td>
                                        <th>1</th>
                                        <td>{{ resourcePrice($resource) }}</td>
                                    </tr>
                                    <tr class="t-14">
                                        <td></td>
                                        <td></td>
                                        <th>{{ __('payment.subtotal') }}</th>
                                        <td>{{ resourcePrice($resource) }}</td>
                                    </tr>
                                    <tr class="t-14" id="giftTable" style="display: none">
                                        <td class="w-50"></td>
                                        <td></td>
                                        <th>{{ __('payment.gift.title') }}</th>
                                        <td>-<span
                                                id="gift">0</span>{{ currency($resource->user->paymentInfo->currency) }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <div>
                                    <label for="giftCode" class="form-label">{{ __('payment.gift.title') }}</label>
                                    <input type="text" class="form-control rounded-1" id="giftCode" name="gift"
                                           data-url="{{ route('api.v1.gift', ['code' => '%code%', 'resource' => $resource->id, 'user' => user()->id]) }}"
                                           placeholder="{{ __('payment.gift.placeholder') }}">
                                    <div class="invalid-feedback">
                                        {{ __('payment.gift.error') }}
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-end">
                                    <h4>{{ __('payment.total_end') }}</h4>
                                    <p class="ms-3 h4 text-info">{!! formatPriceWithId($resource->price, $resource->user->paymentInfo->currency) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
