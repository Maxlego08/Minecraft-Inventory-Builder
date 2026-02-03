@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('icon')
    <div class="error-icon" style="background: rgba(243, 189, 0, 0.1);">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#F3BD00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="13 17 18 12 13 7"/><polyline points="6 17 11 12 6 7"/></svg>
    </div>
@endsection
@section('message', __('You have sent too many requests in a short period of time. Please wait a moment before trying again.'))
