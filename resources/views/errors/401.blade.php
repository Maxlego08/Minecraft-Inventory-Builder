@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('icon')
    <div class="error-icon" style="background: rgba(243, 189, 0, 0.1);">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#F3BD00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
    </div>
@endsection
@section('message', __('You need to be authenticated to access this page. Please log in and try again.'))
