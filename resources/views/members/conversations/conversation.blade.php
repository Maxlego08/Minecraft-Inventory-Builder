<div class="conversation card rounded-1 mt-2 mb-2" @if($message->id===$lastMessage->id)id="last"@endif>
    <div class="conversation-user">
        <a href="{{ $message->user->authorPage() }}" class="conversation-user-avatar"
           title="{{ $message->user->name }} profile">
            <img src="{{ $message->user->getProfilePhotoUrlAttribute() }}"
                 height='50' width='50' alt='{{ $message->user->name }} avatar' class='rounded-2'>
        </a>
        <a href="{{ $message->user->authorPage() }}"
           class="conversation-user-name">{!! $message->user->displayName()  !!}</a>
    </div>
    <div class="conversation-content">
        <div class="conversation-content-text">
            {!! $message->toHTML() !!}
        </div>
        <div class="conversation-content-footer">
            <a href="{{ $message->user->authorPage() }}"
               class="conversation-user-name">{{ $message->user->name }}</a>, {{ format($message->created_at) }}
        </div>
    </div>
</div>
