@extends('members.layouts.app')

@section('content-member')

    <div class="mt-3">
        @include('members.elements.command')
        @include('members.elements.photo')
        @include('members.elements.email')
        @include('members.elements.password')
        @include('members.elements.discord')
        @include('newsletter.newsletter')
        @include('profile.two-factor-authentication-form')

    </div>

@endsection
