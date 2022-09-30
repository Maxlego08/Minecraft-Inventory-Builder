<span class="nav-link dropdown-toggle bell text-white px-2" id="alertDropdown"
   role="button"
   data-bs-toggle="dropdown"
   aria-expanded="false" data-bs-display="static"
   data-bs-auto-close="outside"
    >
    <i class="bi bi-bell-fill"></i>
    @if($alertCount > 0)
        <span class="badge rounded-pill bg-danger">{{ $alertCount }} <span
                class="visually-hidden">{{ __('alerts.unread') }}</span></span>
    @endif
</span>
<div class="dropdown-menu dropdown-menu-dark dropdown-menu-end py-0" data-bs-popper="none">
    <span class="px-3 border-bottom w-100 d-block text-muted py-2">{{ __('alerts.alert') }}</span>
    <div class="px-3 w-100 py-2">
        <ul class="list-group py-2 list-d rounded-0">
            @if($alertCount > 0)
            <li class="list-group-item list-group-item-success fs-7">test</li>
            @else
            <li class="list-group-item list-group-item-success fs-7"><i class="bi bi-check2-circle"></i> {{ __('alerts.none') }}</li>
            @endif
        </ul>
    </div>
</div>
