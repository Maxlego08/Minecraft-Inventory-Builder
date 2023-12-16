@extends('layouts.app')

@section('title', 'Test tooltip')

@section('content')

    <div style="padding: 50px">
        <div class='user-tooltip'>

            <div class="user-tooltip-header d-flex">
                <div class="me-2">
                    <img src="{{ $user->getProfilePhotoUrlAttribute() }}" height="50" width="50"
                         alt="{{ $user->name }}" class="rounded-2">
                </div>
                <div class="d-flex flex-column">
                    <span class="name">{!! $user->displayNameAndLink(false) !!}</span>
                    <span class="join-info">{{ __('tooltip.join_at') }}{{ simple_date($user->created_at) }}</span>
                </div>
            </div>
            <div class="user-tooltip-content">
                <a class="conversation-button rounded-1" href="{{ $user->createConversation() }}">{{ __('tooltip.conversation') }}</a>
            </div>

        </div>
    </div>

@endsection
