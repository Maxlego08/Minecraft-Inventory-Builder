<span class="nav-link dropdown-toggle bell text-white px-2" id="alertDropdown"
      role="button"
      data-bs-toggle="dropdown"
      aria-expanded="false" data-bs-display="static"
      data-bs-auto-close="outside"
>
    <i class="bi bi-bell-fill"></i>
    @if($alertCount > 0)
        <span class="badge rounded-pill bg-danger" id="alert-count">{{ $alertCount }} <span
                class="visually-hidden">{{ __('alerts.unread') }}</span></span>
    @endif
</span>
<div class="dropdown-menu dropdown-menu-dark dropdown-menu-end py-0" data-bs-popper="none">
    <span class="px-3 border-bottom w-100 d-block text-muted py-2 d-flex justify-content-between">
        {{ __('alerts.alert') }}
        <a href="{{ route('profile.alerts') }}">{{ __('alerts.show') }}</a>
    </span>
    <div class="px-3 w-100 py-2">
        <ul class="list-group py-2 list-d rounded-1" id="alerts">
            @if($alertCount > 0)
                {{--
                <li class="list-group-item list-group-item-light fs-7 rounded-1">test</li>
                <li class="list-group-item list-group-item-light fs-7 rounded-1 mt-1 p-1">
                    <div class="d-flex">
                        <img src="http://mib.test/storage/profile-photos/GtH3EGKiziqqtQAmydYyKVxT0Ol7d9xvfcwdbXGf.png"
                             height="50" width="50" alt="Maxlego08" class="rounded-2">
                        <div class="ms-1">
                            {!! __('alerts.alerts.resources.update', ['user' => '<a href="#">Maxlego08</a>', 'content' => '<a href="#">[1.8-1.19] zAuctionHouse (+1200 servers online)</a>']) !!}
                        </div>
                    </div>
                </li>
                <li class="list-group-item list-group-item-danger fs-7 rounded-1 mt-1 p-1">
                    <div class="d-flex">
                        <i class="bi bi-trash3 fs-2"></i>
                        <div class="ms-1">
                            {!! __('alerts.alerts.resources.delete', ['user' => '<a href="#">Maxlego08</a>', 'content' => '<a href="#">[1.8-1.19] zAuctionHouse (+1200 servers online)</a>']) !!}
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
