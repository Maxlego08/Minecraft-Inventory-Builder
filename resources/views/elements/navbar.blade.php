<nav class="navbar py-0 navbar-expand-lg navbar-dark bg-blue-800 flex-column ">
    <div class="container flex-lg-wrap justify-content-center px-2 px-sm-4 px-lg-3 py-4">
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarheader"
                aria-controls="navbarheader" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand  me-0 flex-grow-1 text-center text-lg-start" href="/">
            <img
                src="{{asset('images/logo.svg')}}" alt="Logo du site">
        </a>
        <form class="ms-auto me-0 flex-grow-1 d-none d-lg-flex header_search" id="header_search" role="search">
            <input class="form-control me-2 border-0 rounded-1 bg-blue-700" type="text" placeholder="{{ __('resources.search') }}"
                   aria-label="{{ __('resources.search') }}">
            <button class="btn btn-link" type="submit" title="Valider la recherche du serveur"><i
                    class="bi bi-search"></i></button>
        </form>
        <ul class="navbar list-unstyled ms-auto me-0 mb-0 ms-lg-4 flex-nowrap align-items-center">
            @guest()
                <li class="nav-item">
                    <a class="nav-link py-2 me-2" href="{{route('register')}}"><i class="bi bi-person-plus"></i>
                        Inscription</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 me-2" href="{{route('login')}}"><i class="bi bi-person"></i> Connexion</a>
                </li>
            @endguest
            @auth()
                <li class="nav-item dropdown d-none d-lg-block">
                    @include('elements.alerts')
                </li>
                <li class="nav-item d-none d-lg-block">
                    @include('elements.messages')
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center ms-1 avatar_dropdown" href="#"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false" data-bs-display="static">
                        <img src="{{ user()->getProfilePhotoUrlAttribute() }}" height="30" width="30" alt="{{ user()->name }}" class="rounded-circle">
                        <span class=" d-none d-lg-block ms-2">{{ user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" data-bs-popper="none">
                        <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="dropdown-item">
                                    {{ __('Logout') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            @endauth
        </ul>
    </div>
    <div class="w-100 bg-blue-900">
        <div class="container position-relative collapse navbar-collapse w-100" id="navbarheader">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 py-2 rounded-4">
                <li class="nav-item">
                    <a class="nav-link py-2 me-2 {{ Route::currentRouteNamed('home') ? "active fw-bold" : ""}}"
                       {{Route::currentRouteNamed(('home')) ?"aria-current='page''" : ""}} href="{{route('home')}}">{{ __('messages.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  py-2 me-2" href="#">{{ __('messages.inventory-builder') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  py-2 me-2 {{ Route::currentRouteNamed('resources.*') ? "active fw-bold" : ""}}"
                       {{Route::currentRouteNamed(('resources.*')) ?"aria-current='page''" : ""}} href="{{route('resources.index')}}">{{ __('messages.resources') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 me-2" href="https://docs.zmenu.dev/" target="_blank" title="{{ __('messages.documentation') }}">{{ __('messages.documentation') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 me-2" href="#">{{ __('messages.premium') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 me-2" href="https://discord.groupez.dev/" target="_blank" title="Discord">Discord</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
