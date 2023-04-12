<div class="col-md-6 col-lg-12">
    <div class="card mb-3 rounded-0">
        <div class="card-body">
            <h2 class="text-center fs-5 fw-bold">{{ __('resources.most.title') }}</h2>
            <ul class="list-group">
                @foreach($mostResources as $ms)
                <li class="d-flex mb-2">
                    <a class="img_1"
                       href="{{ $ms['url'] }}"
                       title="{{ $ms['name'] }} profile">
                        <img class=""
                             src="{{ $ms['image'] }}"
                             alt="{{ $ms['name'] }}" width="50" height="50">
                    </a>
                    <div class="ms-3">
                        <p class="mb-0 fw-light">{{ $ms['name'] }}</p>
                        <span class="text-muted fs-7">{{ __('messages.resources') }}: {{ $ms['count'] }}</span>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
