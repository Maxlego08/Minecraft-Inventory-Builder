<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-text mx-3">MIB</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

@foreach(config('sidebar.elements') as $elements => $element)

    @if (isset($element['role']))
        <!-- Do nothing -->
        @else
            <div class="sidebar-heading">
                {{ __($element['title']) }}
            </div>

            @foreach($element['routes'] as $route)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route($route['route']) }}">
                        <i class="{{ $route['icon'] }}"></i>
                        <span>{{ __($route['name']) }}</span>
                    </a>
                </li>
            @endforeach

            <hr class="sidebar-divider">
    @endif

@endforeach

<!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
