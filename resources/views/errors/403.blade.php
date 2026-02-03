@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('icon')
    <div class="error-icon" style="background: rgba(220, 53, 69, 0.1);">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
    </div>
@endsection
@section('message', __($exception->getMessage() ?: 'You do not have permission to access this page. If you believe this is an error, please contact an administrator.'))
