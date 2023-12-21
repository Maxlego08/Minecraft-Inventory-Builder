@extends('layouts.app')

@section('title', 'Test tooltip')

@section('content')

    <div style="padding: 50px">
        <div class='user-tooltip'>

            <div class="user-tooltip-header d-flex"
                 @if(isset($user->banner_photo_path))
                     style="
                     background-image: url('{{ $user->getBannerUrlAttribute() }}') ;
                     background-repeat: no-repeat;
                     background-size: cover;
                     background-position: 0 0;
                     "
                @endif
            >
                <div class="me-2">
                    <img src="{{ $user->getProfilePhotoLargeUrlAttribute() }}" height="75" width="75"
                         alt="{{ $user->name }}" class="rounded-2">
                </div>
                <div class="d-flex flex-column">
                    <span class="name h5 mb-0">{!! $user->displayNameAndLink(false) !!}</span>
                    <div class="pt-2 pb-2">
                        {!! $user->role->getRoleIcon() !!}
                    </div>
                    <span class="join-info">{{ __('tooltip.join_at') }}{{ simple_date($user->created_at) }}</span>
                </div>
            </div>
            <div class="user-tooltip-content">
                @if($user->hasTooltipInformations())
                    <div class="d-flex justify-content-evenly user-tooltip-content-informations">
                        <div class="d-flex flex-column">
                            <span>{{ __('tooltip.resources') }}</span>
                            <span class="text-center">{{ $user->getTooltipInformations()['resources'] }}</span>
                        </div>
                        <div class="d-flex flex-column">
                            <span>{{ __('tooltip.payments') }}</span>
                            <span class="text-center">{{ $user->getTooltipInformations()['payments'] }}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="user-tooltip-content-buttons">
                        @else
                            <div class="user-tooltip-content-buttons pt-3">
                                @endif
                                @if(!$user->enable_conversation)
                                    <span class="conversation-button rounded-1 disabled cursor-disabled">{{ __('tooltip.conversation') }}</span>
                                @else
                                    <a class="conversation-button rounded-1 @if(!$user->enable_conversation) disabled cursor-disabled @endif"
                                       href="{{ $user->createConversation() }}">{{ __('tooltip.conversation') }}</a>
                                @endif

                            </div>
                    </div>

            </div>
        </div>

@endsection
