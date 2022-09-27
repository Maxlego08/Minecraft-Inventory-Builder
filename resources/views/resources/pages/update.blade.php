@for ($i = 0; $i < 3; $i++)
    <div class="card mb-4">
        <div class="card-body">
            <a href="#" class="fs-5 mb-3 d-block" title="Mise à jour #3">Mise à jour #3 - Bug fixes v15.356.2</a>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas egestas nibh at ante luctus convallis.
                Cras
                eget placerat felis, eu fringilla enim. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices
                posuere
                cubilia curae; Sed vulputate, odio nec dapibus blandit, libero leo facilisis leo, sed interdum turpis
                diam a
                arcu. Integer at elementum est. Etiam vulputate lacus ut est posuere, vitae feugiat orci tempus. Morbi
                id
                elementum eros, quis viverra felis. Maecenas dignissim ligula quis orci tincidunt tincidunt.
            </p>
            <span>Posté par <span class="text-danger">Maxlego08</span>, le 17 jui. 2022</span>
        </div>
    </div>
@endfor

@include('elements.pagination')
