<nav class="navbar py-0 navbar-expand-lg navbar-dark bg-blue-800 flex-column ">
    <div class="container flex-lg-wrap justify-content-center px-4 px-lg-3 py-4">
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
            <input class="form-control me-2 border-0 bg-blue-700" type="text" placeholder="Rechercher une ressource..."
                   aria-label="Rechercher une ressource...">
            <button class="btn btn-link" type="submit" title="Valider la recherche du serveur"><i
                    class="bi bi-search"></i></button>
        </form>
        <ul class="navbar list-unstyled ms-auto me-0 mb-0 ms-lg-4 flex-nowrap align-items-center">
            <li class="nav-item d-none d-lg-block">
                <a class="bell text-white px-2" href="#"><i class="bi bi-bell-fill"></i></a>
            </li>
            <li class="nav-item d-none d-lg-block">
                <a class="position-relative text-white px-2 envelope" href="#">
                    <i class="bi bi-envelope-fill"></i>
                    <span
                        class="position-absolute bottom-0 start-100 rounded-circle bg-danger"><span
                            class="visually-hidden">unread messages</span></span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center ms-1 avatar_dropdown" href="#"
                   role="button"
                   data-bs-toggle="dropdown"
                   aria-expanded="false" data-bs-display="static">
                    <img src="{{asset('images/ut.png')}}" height="30" width="30" alt="Utilisateur">
                    <span class=" d-none d-lg-block ms-2">Utilisateur</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" data-bs-popper="none">
                    <li><a class="dropdown-item" href="{{route('login')}}">Connexion</a></li>
                    <li><a class="dropdown-item" href="{{route('register')}}">Inscription</a></li>
                    <li><a class="dropdown-item" href="{{route('profil')}}">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Déconexion</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="w-100 bg-blue-900">
        <div class="container position-relative collapse navbar-collapse w-100" id="navbarheader">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 py-2 rounded-4">
                <li class="nav-item">
                    <a class="nav-link py-2 me-2 {{ Route::currentRouteNamed('home') ? "active fw-bold" : ""}}"
                       {{Route::currentRouteNamed(('home')) ?"aria-current='page''" : ""}} href="{{route('home')}}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  py-2 me-2" href="#">Builder</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  py-2 me-2 {{ Route::currentRouteNamed('resources.*') ? "active fw-bold" : ""}}"
                       {{Route::currentRouteNamed(('resources.*')) ?"aria-current='page''" : ""}} href="{{route('resources.index')}}">Ressources</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  py-2 me-2" href="#">Documentation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  py-2 me-2" href="#">Abonnement</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  py-2 me-2" href="#">Discord</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
