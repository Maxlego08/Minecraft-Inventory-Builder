@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('icon')
    <div class="error-icon" style="background: rgba(243, 189, 0, 0.1);">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#F3BD00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
@endsection
@section('message', __('Your session has expired. Please refresh the page and try again.'))
