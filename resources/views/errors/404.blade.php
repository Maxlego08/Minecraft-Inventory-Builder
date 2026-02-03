@extends('errors::minimal')

@section('title', __('Page Not Found'))
@section('code', '404')
@section('icon')
    <div class="error-icon" style="background: rgba(243, 189, 0, 0.1);">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#F3BD00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
    </div>
@endsection
@section('message', __($exception->getMessage() ?: 'The page you are looking for does not exist or has been moved. Check the URL or go back to the home page.'))
