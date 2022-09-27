@for ($i = 0; $i < 3; $i++)
    <div class="card mb-4 {{ $i !=0 ? 'mt-5':''}}">
        <div class="card-body">
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <a href="https://groupez.dev/resources/authors/maxlego08.1"
                   title="Maxlego08 profile">
                    <img class=" rounded-circle"
                         src="https://groupez.dev/storage/images/users/0/0/0/1.png"
                         alt="Maxlego08 Avatar">
                </a>
                <div class="ms-3">
                    <a href="#" class="fw-bold text-decoration-none" title="anonymuser0023">anonymuser0023</a>
                    <span class="mt-2 ms-3 d-inline-flex">
                    @include('elements.stars')
                    </span>
                    <span class="text-muted fw-light fs-7 ms-3 text-nowrap">Version: v12.356.2</span>
                    <p class="mt-3 mb-1">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas egestas nibh at ante luctus
                        convallis.
                        Cras
                        eget placerat felis, eu fringilla enim. Vestibulum ante ipsum primis in faucibus orci luctus et
                        ultrices
                        posuere
                        cubilia curae; Sed vulputate, odio nec dapibus blandit, libero leo facilisis leo, sed interdum
                        turpis
                        diam a
                        arcu. Integer at elementum est. Etiam vulputate lacus ut est posuere, vitae feugiat orci tempus.
                        Morbi
                        id
                        elementum eros, quis viverra felis. Maecenas dignissim ligula quis orci tincidunt tincidunt.
                    </p>
                    <span class="text-muted fs-7 fw-light fst-italic">le 17 jui. 2022</span>
                </div>
            </div>
        </div>
    </div>

    @for ($d = 0; $d < 3; $d++)
        <div class="block_resources_description my-2 d-flex card card-body flex-row flex-wrap flex-sm-nowrap">
            <a href="https://groupez.dev/resources/authors/maxlego08.1"
               title="Maxlego08 profile">
                <img class=" rounded-circle"
                     src="https://groupez.dev/storage/images/users/0/0/0/1.png"
                     alt="Maxlego08 Avatar">
            </a>
            <div class="ms-3">
                <a href="#" class="fw-bold text-decoration-none text-warning" title="anonymuser0023">Maxlego08
                    <div class="badge bg-warning ms-2"> Auteur</div>
                </a>
                <p class="mt-1 mb-1">Thanks for your review!</p>
                <span class="text-muted fs-7 fw-light fst-italic">le 17 jui. 2022</span>
            </div>
        </div>
    @endfor
@endfor

@include('elements.pagination')
