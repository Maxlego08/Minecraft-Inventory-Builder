@extends('layouts.base')

@section('title', 'GroupeZ')

@section('app')
    <div class="content_home pb-5">
        <article class="home_background">
            <img class="img-fluid" src="{{asset('images/newfondavril.png')}}" alt="">
            <div class="home_background_text">
                <h1 class="display-5 fw-semibold">Minecraft Inventory Builder</h1>
                <p class="fs-7">{{ __('about.description') }}</p>
                <p class="fs-1 text-danger"><i class="bi bi-exclamation"></i> IN DEVELOPMENT <i
                        class="bi bi-exclamation"></i></p>
            </div>
            <a href="#home_marketplace" class="home_arrow_scroll text-white"><i class="bi bi-arrow-down fs-2"></i></a>
        </article>
        <article class="home_marketplace pb-5" id="home_marketplace">
            <div class="container">
                <div class="row px-4 px-lg-0">
                    <div class="col-lg-4">
                        <img class="d-none d-lg-block img-fluid w-100 pe-5" src="https://via.placeholder.com/300"
                             alt="">
                    </div>
                    <div class="col-lg-8">
                        <h2 class="mt-2">Le Marketplace GroupeZ, c’est quoi ?</h2>
                        <img class="d-block d-lg-none img-fluid rounded-4 my-4 w-100"
                             src="https://via.placeholder.com/360" alt="">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas egestas nibh at ante luctus
                            convallis. Cras eget placerat felis, eu fringilla enim. Vestibulum ante ipsum primis in
                            faucibus
                            orci luctus et ultrices posuere cubilia curae; Sed vulputate, odio nec dapibus blandit,
                            libero
                            leo facilisis leo, sed interdum turpis diam a arcu. Integer at elementum est. Etiam
                            vulputate
                            lacus ut est posuere, vitae feugiat orci tempus. Morbi id elementum eros, quis viverra
                            felis.
                            Maecenas dignissim ligula quis orci tincidunt tincidunt.

                            Nulla in purus nec purus gravida rhoncus. Proin vulputate euismod purus, sed iaculis neque
                            fermentum non. Fusce at lacus mollis massa sollicitudin hendrerit. Suspendisse purus sem,
                            lobortis sed euismod sagittis, dignissim eu ex. Fusce eget mauris pellentesque, maximus
                            risus
                            faucibus, fermentum ex. Pellentesque pretium laoreet nisi et dignissim. Praesent vel
                            faucibus
                            ligula. Curabitur ut tincidunt ante. Cras finibus hendrerit libero, non commodo nisi.

                            Integer at elementum est. Etiam vulputate lacus ut est posuere, vitae feugiat orci tempus.
                            Morbi
                            id elementum eros, quis viverra felis. Maecenas dignissim ligula quis orci tincidunt
                            tincidunt.</p>
                        <div class="row row-cols-lg-3 flex-column flex-sm-row bg-blue-800 text-center rounded-1 justify-content-evenly
                        align-items-center py-2 mt-4 home_marketplace_block">
                            <div class="mb-3 mb-lg-0">
                                <i class="bi bi-percent fs-2"></i>
                                <h3 class="fs-5">Aucune taxe</h3>
                                <p class="fs-7">GroupeZ ne prend aucun pourcentage sur vos ventes !</p>
                            </div>
                            <div class="mb-3 mb-lg-0">
                                <i class="bi bi-clipboard-check-fill fs-2"></i>
                                <h3 class="fs-5">Aucune taxe</h3>
                                <p class="fs-7">Vendez vos produits sous licence, protégez vos créations contre les
                                    leaks.</p>
                            </div>
                            <div>
                                <i class="bi bi-file-earmark-lock-fill fs-2"></i>
                                <h3 class="fs-5">Sécurisé</h3>
                                <p class="fs-7">La vente de vos ressources est entièrement sécurisée et automatique.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 270"
             fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M0 90.5202L107 97.5434C213 105.347 427 120.173 640 105.347C853 90.5202 1067 45.2601 1280 22.6301C1493 0 1707 0 1813 0H1920V270H1813C1707 270 1493 270 1280 270C1067 270 853 270 640 270C427 270 213 270 107 270H0V90.5202Z"
                  fill="#1A1A2E"/>
        </svg>
        <article class="home_abonnement bg-blue-800">
            <div class="container">
                <div class="text-center block_title">
                    <h2>{{ __('upgrade.title') }}</h2>
                    <p>{{ __('upgrade.description') }}</p>
                </div>
                <div class="px-3 px-lg-0">
                    <div class="row g-5 row-cols-lg-3">
                        @include('members.elements.premium.member')
                        @include('members.elements.premium.premium')
                        @include('members.elements.premium.pro')
                    </div>
                </div>
            </div>
        </article>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 270"
             fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M1920 179.48L1813 172.457C1707 164.653 1493 149.827 1280 164.653C1067 179.48 853 224.74 640 247.37C427 270 213 270 107 270L0 270L2.36041e-05 7.62889e-05L107 8.56431e-05C213 9.49099e-05 427 0.000113618 640 0.000132239C853 0.000150861 1067 0.000169569 1280 0.00018819C1493 0.000206811 1707 0.00022552 1813 0.000234786L1920 0.000244141L1920 179.48Z"
                  fill="#1A1A2E"/>
        </svg>
        <article class="home_ressources pb-5">
            <div class="container">
                <div class="px-3 px-lg-0">
                    <div class="text-center block_title pt-5 mb-5">
                        <h2>Ressources</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas egestas nibh at ante luctus
                            convallis. Cras eget placerat felis.</p>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-lg-5">
                            <div class="bg-blue-800 rounded-1 p-4 me-lg-5 mb-4 text-center">
                                <h3 class="fs-5">Notre système de ressource</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas egestas nibh at
                                    ante
                                    luctus convallis. Cras eget placerat felis. Maecenas egestas nibh at ante luctus
                                    convallis. Cras eget placerat felis. Maecenas egestas nibh at ante luctus convallis.
                                    Cras eget placerat felis. </p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-center">
                                <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas
                                    egestas nibh at
                                    ante luctus convallis. Cras eget placerat felis. Maecenas egestas nibh at ante
                                    luctus convallis. Cras eget placerat felis. Maecenas egestas nibh at ante luctus
                                    convallis. Cras eget placerat felis.</p>
                                <a href="{{route('resources.create.index')}}"
                                   class="home_ressources_add btn btn-primary rounded-1 d-flex align-items-center justify-content-center"><i
                                        class="bi bi-plus-lg me-2 fs-4"></i>AJOUTER UNE RESSOURCE</a>
                            </div>
                        </div>
                    </div>
                    @if ($resource)
                        <div class="row flex-column g-4 mt-4">
                            <div class="col">
                                @include('resources.elements.resource', ['resource' => $resource])
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </article>
    </div>
@endsection
