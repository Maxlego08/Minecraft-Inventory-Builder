@php use App\Models\UserRole; @endphp
@extends('members.layouts.app')

@section('title', __('conversations.title'))

@section('content-member')

    <div class="card rounded-1 mt-3 mb-3">
        <div class="card-body">
            <h2>{{ __('conversations.title') }}</h2>
            <ul class="ps-0 ms-0 py-2 rounded-1" id="conversations">
                @if(count($conversations) == 0)
                    <div class="alert alert-danger">
                        {{ __('conversations.empty') }}
                    </div>
                @endif
                @foreach($conversations as $conversation)
                    <li class="list-group-item rounded-1 mb-2">
                        <div class='d-flex'>
                            <a href="{{ route('profile.conversations.show', $conversation) }}"
                               title="{{ __('conversations.list.title') }}">
                                <img src="{{ $conversation->user->getProfilePhotoUrlAttribute() }}"
                                     height='50' width='50' alt='{{ $conversation->user->name }} avatar'
                                     class='rounded-2'>
                            </a>
                            <div class='ms-2'>
                                <div>
                                    <a href="{{ route('profile.conversations.show', $conversation) }}"
                                       class="text-decoration-none"
                                       title="{{ __('conversations.list.title') }}">
                                        {{ $conversation->subject }}
                                    </a>
                                </div>
                                <div class="d-flex flex-column">
                                    <small
                                        class="text-secondary">{!! __('conversations.list.last', ['date' => format($conversation->last_message_at), 'name' => "<a href='".route('resources.author', ['user' => $conversation->getLastMessage()->user, 'slug' => $conversation->getLastMessage()->user->slug()])."' class='text-decoration-none'>".$conversation->getLastMessage()->user->name."</a>", 'link' => $conversation->getLastMessageURL()]) !!}</small>
                                    <small
                                        class="text-secondary">{!! __('conversations.list.start', ['date' => format($conversation->created_at), 'name' => "<a href='".route('resources.author', ['user' => $conversation->user, 'slug' => $conversation->user->slug()])."' class='text-decoration-none'>".$conversation->user->name."</a>"]) !!}</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </li>
                @endforeach
            </ul>
            {{ $conversations->links() }}

            <div class="my-3">
                <input class="form-check-input" type="checkbox" name="toggle_conversation" id="toggle_conversation" data-token="{{ csrf_token() }}" data-url="{{ route('profile.conversations.toggle') }}" @if(user()->enable_conversation) checked @endif>
                <label class="form-check-label" for="toggle_conversation">{{ __('conversations.enable') }}</label>
            </div>
        </div>
    </div>

    <div class="card rounded-1 mt-3 mb-3">
        <div class="card-body">
            <h2>{{ __('conversations.auto.title') }}</h2>
            @if(user()->role->isPro())

                <form method="POST" action="{{ route('profile.conversations.auto') }}">
                    @csrf

                    @include('elements.textarea', ['content' => user()->autoResponse?->content ?? ''])

                    <div class="my-3">
                        <input class="form-check-input" type="checkbox" name="is_enable" id="is_enable" @if(user()->autoResponse?->is_enable ?? false) checked @endif>
                        <label class="form-check-label" for="is_enable">{{ __('conversations.auto.enable') }}</label>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-1 d-block"><i
                            class="bi bi-send"></i> {{ __('messages.save') }}</button>
                </form>

            @else
                <div class="alert alert-danger">
                    {!! __('conversations.auto.permission', ['role' => "<span class='btn-role btn-pro rounded-1'><i class='me-2 " . UserRole::ICON_PRO . "'></i>Pro</span>"]) !!}
                </div>
            @endif
        </div>
    </div>

@endsection
