@extends('layouts.base')

@section('title', $user->name)

@section('app')

    <div class="content_resources_add pt-5 mb-2 creator">
        <div class="container">
            <div class="card rounded-1">
                <div class="creator-header d-flex"
                     @if(isset($user->banner_photo_path))
                         style="
                         background-image: url('{{ $user->getBannerUrlAttribute() }}') ;
                         background-repeat: no-repeat;
                         background-size: cover;
                         background-position: 0 0;
                         "
                    @endif
                >
                    <img src="{{ $user->getProfilePhotoLargeUrlAttribute() }}" height="150" width="150" alt="User"
                         class="rounded-1">
                    <div class="ms-2 d-flex flex-column">
                        <div class="h3 d-flex align-items-center">
                            {!! $user->displayName(false) !!}
                            @if ($user->cache('name_change')->count() > 0)
                                <i id="username-history" data-names="{{ $user->getNameHistory() }}"
                                   data-title="{{ __('profiles.change.previous') }}"
                                   class="bi bi-clock-history ms-1" title="{{ __('profiles.change.history') }}"
                                   style="font-size: 18px"></i>
                            @endif
                        </div>
                        <div class="pb-2">
                            {!! $user->role->getRoleIcon() !!}
                        </div>
                        <div>
                        </div>
                        <span class="join-info">{{ __('tooltip.join_at') }}{{ simple_date($user->created_at) }}</span>
                    </div>
                </div>
                <div class="creator-content">
                    <div class="creator-content-informations d-flex justify-content-evenly">
                        <div class="d-flex flex-column">
                            <span>{{ __('tooltip.resources') }}</span>
                            <span class="text-center">{{ $user->getTooltipInformations()['resources'] }}</span>
                        </div>
                        <div class="d-flex flex-column">
                            <span>{{ __('tooltip.payments') }}</span>
                            <span class="text-center">{{ $user->getTooltipInformations()['payments'] }}</span>
                        </div>
                        <div class="d-flex flex-column">
                            <span>{{ __('tooltip.reactions') }}</span>
                            <span class="text-center">{{ $user->getTooltipInformations()['reactions'] }}</span>
                        </div>
                        <div class="d-flex flex-column">
                            <span>{{ __('tooltip.followers') }}</span>
                            <span class="text-center">{{ $user->getTooltipInformations()['followers'] }}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="user-tooltip-content-buttons">
                        <a class="conversation-button rounded-1"
                           href="{{ $user->createConversation() }}">{{ __('tooltip.conversation') }}</a>
                        @auth()
                            @if (user()->id != $user->id)
                                @if(user()->cache('followings')->where('id', $user->id)->count() == 0)
                                    <form action="{{ route('profile.follow', $user) }}" method="POST" class="ms-2">
                                        @csrf
                                        <button
                                            class="conversation-button rounded-1">{{ __('messages.follow.follow') }}</button>
                                    </form>
                                @else
                                    <form action="{{ route('profile.unfollow', $user) }}" method="POST" class="ms-2">
                                        @csrf
                                        <button
                                            class="conversation-button rounded-1">{{ __('messages.follow.unfollow') }}</button>
                                    </form>
                                @endif
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content_resources_add mb-5">
        <div class="container">
            <div class="px-0 px-lg-0">
                <div class="row my-4">
                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-md-6 col-lg-12">
                                @include('resources.elements.sponsor')
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        @foreach($resources as $resource)
                            @include('resources.elements.resource', ['resource' => $resource])
                        @endforeach
                        {!! $resources->links('elements.pagination') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
