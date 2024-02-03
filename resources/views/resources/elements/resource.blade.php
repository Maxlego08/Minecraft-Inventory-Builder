<div class="block_resources px-2 bg-blue-800 rounded-1 mb-2">
    <div class="d-flex flex-wrap flex-lg-nowrap">
        <div class="block_resources_start me-0 me-lg-3 d-flex align-items-center">
            <a class="img_1" href="{{ $resource->link('description') }}"
               title="Show {{ $resource->name }} description">
                <img class="" src="{{ $resource->cache('icon')->getPath() }}"
                     alt="{{ $resource->name }} logo" width="50" height="50">
            </a>
            <a class="img_2 position-absolute start-100 top-50"
               href="{{ $resource->cache('user')->authorPage() }}"
               title="{{ $resource->cache('user')->name }} profile">
                <img src="{{ $resource->cache('user')->getProfilePhotoUrlAttribute() }}"
                     alt="{{ $resource->cache('user')->name }} Avatar" width="25" height="25">
            </a>
        </div>
        <div class="block_resources_center ms-2 ms-lg-2 d-flex flex-column justify-content-center">
            <h3 class="fw-bold fs-5 mb-0">
                <a class="link-light text-decoration-none text-break"
                   href="{{ $resource->link('description') }}">{{ $resource->name }}</a>
                <span class="text-muted fw-normal fs-7 ms-2">{{ $resource->cache('version')->version }}</span>
            </h3>
            <div class="text-muted fw-light fs-8 d-flex">
                <div>
                    <a class="text-danger text-decoration-none" href="{{ $resource->user->authorPage() }}">{!! $resource->cache('user')->displayName() !!}</a>
                </div>
                , {{ format_date($resource->created_at) }}, <span>{{ $resource->cache('category') }}</span>
            </div>
            <p class="mt-1 mb-0 fs-7">{{ $resource->tag }}</p>
        </div>
        <div class="block_resources_end d-flex align-items-center justify-content-end flex-grow-1 fs-7">
            @if($resource->price > 0)
                <div class="btn btn-success rounded-1 fw-normal py-0 me-2 me-lg-3">
                    {{ resourcePrice($resource) }}
                </div>
            @endif
            @if ($resource->is_pending)
                <i class="bi bi-eye py-0 me-2 me-lg-3 text-danger"></i>
            @endif
            <ul class="navbar-nav">
                <li class="py-1">
                    <span class="text-warning">
                        {!! $resource->reviewScore() !!}
                    </span>
                    <span class="text-end">{{ $resource->countReviews() }} {{ __('resources.review') }}</span>
                </li>
                <li class="py-1"><span>{{ __('messages.downloads') }}</span>
                    <span>{{ $resource->countDownload() }}</span></li>
                <li class="py-1"><span>{{ __('messages.updated') }}</span>
                    <span>{{ format($resource->created_at) }}</span>
                </li>
            </ul>
        </div>
    </div>
</div>
