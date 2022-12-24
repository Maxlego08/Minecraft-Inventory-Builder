<span class="nav-link dropdown-toggle bell-2 text-white px-2" id="messageDropdown"
      role="button"
      data-bs-toggle="dropdown"
      aria-expanded="false" data-bs-display="static"
      data-bs-auto-close="outside"
>
    <i class="bi bi-envelope-fill"></i>
    @if($messageCount > 0)
        <span class="badge rounded-pill bg-danger" id="message-count">{{ $messageCount }} <span
                class="visually-hidden">{{ __('alerts.unread') }}</span></span>
    @endif
</span>
<div class="dropdown-menu dropdown-menu-dark dropdown-menu-end py-0" data-bs-popper="none">
    <span class="px-3 border-bottom w-100 d-block text-muted py-2 d-flex justify-content-between">
        {{ __('alerts.message.title') }}
        <a href="{{ route('profile.conversations.index') }}">{{ __('alerts.show') }}</a>
    </span>
    <div class="px-3 w-100 py-2">
        <ul class="list-group py-2 list-d rounded-0" id="messages">
            @if($messageCount > 0)
                {{--
                <li class="list-group-item list-group-item-light fs-7 rounded-0 mt-1 p-1">
                    <div class="d-flex">
                        <a href="" title="User link">
                            <img src="http://mib.test/storage/profile-photos/8N9YUmZ5u5R3g1Ys9A5Mw8cENsQHejzquSlu59Ty.png"
                                 height="50" width="50" alt="Maxlego08" class="rounded-2">
                        </a>
                        <div class="ms-1">
                            {!! __('alerts.alerts.messages', ['user' => '<a href="#">Maxlego08</a>', 'conversation' => '<a href="">Ceci est un test de conversation</a>']) !!}
                        </div>
                    </div>
                </li>
                --}}
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
                </div>
            @else
            @endif
        </ul>
    </div>
</div>

