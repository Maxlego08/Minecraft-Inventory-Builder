@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('icon')
    <div class="error-icon" style="background: rgba(220, 53, 69, 0.1);">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    </div>
@endsection
@section('message', __('An internal server error occurred. Our team has been notified. Please try again later or contact us on Discord.'))
