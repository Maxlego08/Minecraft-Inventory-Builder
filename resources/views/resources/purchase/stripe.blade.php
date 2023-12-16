@extends('layouts.base')

@section('title', "Stripe")

@section('app')

    <div class="container" style="margin-top: 250px; margin-bottom: 250px">
        <div class="d-flex justify-content-center">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

@endsection


@push('footer-scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        window.onload = function () {
            let stripe = Stripe('{{ $pk_live }}');
            stripe.redirectToCheckout({
                sessionId: '{{ $payment_id }}'
            });
        };
    </script>
@endpush
