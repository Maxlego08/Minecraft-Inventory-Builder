@extends('errors::minimal')

@section('title', __('Maintenance in Progress'))
@section('code', '503')
@section('icon')
    <div class="error-icon" style="background: rgba(69, 190, 233, 0.1);">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#45BEE9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
    </div>
@endsection
@section('message', __('The site is currently undergoing maintenance. Please check back shortly or visit our Discord for more information: discord.groupez.dev'))
