<footer class="footer position-relative bg-blue-900 py-5">
    <div class="container-fluid">
        <div class="position-absolute top-0 start-50 translate-middle bg-blue-900 p-2 ps-5 pe-5 text-center text-uppercase fs-5 message">
            <span>Minecraft Inventory Builder</span>
        </div>
        <div class="row justify-content-evenly gy-4 px-4 px-xl-0">
            <div class="col-lg-6 col-xl-2 offset-xl-1">
                <div class="copyright">
                    <a class="mx-auto mb-3 d-block" href="{{ route('home') }}">
                        <img src="{{asset('images/logo.svg')}}" alt="Logo du site">
                    </a>
                    <p class="mb-0">
                        <span class="text-uppercase fs-6 d-block">{{ \Carbon\Carbon::now()->year }} © <a class="text-decoration-none" href="{{ route('home') }}">ZMenu Marketplace</a></span>
                        <span class="fs-7 d-block">{{ __('messages.copyright') }}.</span>
                    </p>
                    <ul class="d-flex list-unstyled pt-0 pb-0">
                        <li class="nav-item">
                            <a class="nav-link link-primary" href="https://discord.groupez.dev/" target="_blank"><i class="bi bi-discord fs-3"></i></a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="nav-link link-primary" href="https://docs.zmenu.dev/" target="_blank"><i class="bi bi-newspaper fs-3"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <h2 class="text-primary fw-bold fs-4 text-uppercase">{{ __('messages.about.title') }}</h2>
                <p>{{ __('messages.about.content') }}</p>
            </div>
            <div class="col-xs-6 col-xl-2">
                <h2 class="text-primary fw-bold fs-4 text-uppercase">{{ __('messages.links.title') }}</h2>
                <ul class="list-unstyled">
                    <li><a class="link-light text-decoration-none" href="{{ route('resources.create.index') }}">Create a resource</a></li>
                    <li><a class="link-light text-decoration-none" href="#">Terms</a></li>
                    <li><a class="link-light text-decoration-none" href="#">Rule</a></li>
                    <li><a class="link-light text-decoration-none" href="https://discord.groupez.dev/" target="_blank">Discord</a></li>
                    <li><a class="link-light text-decoration-none" href="https://discord.groupez.dev/" target="_blank">Contact us</a></li>
                    <li><a class="link-light text-decoration-none" href="https://serveur-minecraft-vote.fr/" target="_blank">Serveur minecraft Vote</a></li>
                </ul>
            </div>
            <div class="col-xs-6 col-xl-2">
                <h2 class="text-primary fw-bold fs-4 text-uppercase">{{ __('messages.developer.title') }}</h2>
                <ul class="list-unstyled">
                    <li><a class="link-light text-decoration-none" href="https://github.com/Maxlego08/Minecraft-Inventory-Builder" target="_blank" title="GroupeZ website">Github</a></li>
                    <li><a class="link-light text-decoration-none" href="https://groupez.dev/" target="_blank" title="GroupeZ website">GroupeZ</a></li>
                    <li><a class="link-light text-decoration-none" href="https://docs.zmenu.dev/" target="_blank" title="zMenu documentation">Documentation</a></li>
                    <li><a class="link-light text-decoration-none" href="https://serveur-minecraft-vote.fr/" target="_blank" title="Serveur Minecraft Vote website">Serveur Minecraft Vote</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
