<div class="conversation card rounded-0 mt-2 mb-2">
    <div class="conversation-user">
        <a href="{{ route('resources.author', $message->user) }}" class="conversation-user-avatar"
           title="{{ $message->user->name }} profile">
            <img src="{{ $message->user->getProfilePhotoUrlAttribute() }}"
                 height='50' width='50' alt='{{ $message->user->name }} avatar' class='rounded-2'>
        </a>
        <a href="{{ route('resources.author', $message->user) }}"
           class="conversation-user-name">{{ $message->user->name }}</a>
    </div>
    <div class="conversation-content">
        <div class="conversation-content-text">
            {!! $message->toHTML() !!}
        </div>
        <div class="conversation-content-footer">
            <a href="{{ route('resources.author', $message->user) }}"
               class="conversation-user-name">{{ $message->user->name }}</a>, {{ format($message->created_at) }}
        </div>
    </div>
</div>
