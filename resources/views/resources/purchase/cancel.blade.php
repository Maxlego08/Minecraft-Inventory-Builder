@extends('layouts.base')

@section('title', "Payment Cancel")

@section('app')

    <div class="container" style="margin-bottom: 100px; margin-top: 100px">
        <div class="d-flex justify-content-center align-items-center flex-column">
            <h2 class="mb-5">{{ __('payment.cancel') }}</h2>
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2" style="width: 100px">
                <circle class="path circle" fill="none" stroke="#D06079" stroke-width="6"
                        stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round"
                      stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/>
                <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round"
                      stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/>
            </svg>
        </div>
    </div>

@endsection

@push('footer-scripts')
    <script>
        setTimeout(function () {
            window.location.href = '{{ route('resources.index') }}'
        }, 1000 * 5)
    </script>
@endpush
