@extends('members.layouts.app')

@section('title', __('conversations.title'))

@section('content-member')

    <div class="card rounded-0 mt-3 mb-3">
        <div class="card-body">
            <h2>{{ __('conversations.title') }}</h2>
            <ul class="ps-0 ms-0 py-2 rounded-0" id="conversations">
                @foreach($conversations as $conversation)
                    <li class="list-group-item rounded-0 mb-2">
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
                                    <small class="text-secondary">{!! __('conversations.list.last', ['date' => format($conversation->last_message_at), 'name' => "<a href='".route('resources.author', $conversation->getLastMessage()->user)."' class='text-decoration-none'>".$conversation->getLastMessage()->user->name."</a>", 'link' => $conversation->getLastMessageURL()]) !!}</small>
                                    <small class="text-secondary">{!! __('conversations.list.start', ['date' => format($conversation->created_at), 'name' => "<a href='".route('resources.author', $conversation->user)."' class='text-decoration-none'>".$conversation->user->name."</a>"]) !!}</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </li>
                @endforeach
            </ul>
            {{ $conversations->links() }}
        </div>
    </div>
@endsection
