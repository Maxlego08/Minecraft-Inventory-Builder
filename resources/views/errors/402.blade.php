@extends('errors::minimal')

@section('title', __('Payment Required'))
@section('code', '402')
@section('icon')
    <div class="error-icon" style="background: rgba(69, 190, 233, 0.1);">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#45BEE9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
    </div>
@endsection
@section('message', __('A payment is required to access this content. Please check your subscription or complete the purchase.'))
