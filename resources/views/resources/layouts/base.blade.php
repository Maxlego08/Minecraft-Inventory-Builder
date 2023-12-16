@extends('layouts.base')

@section('app')
    <div class="content_resources_show mb-5">
        <div class="container">
            <div class="px-3 px-lg-0">
                <div class="card my-4 rounded-1">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-7 col-xl-9 d-flex align-items-center flex-wrap flex-sm-nowrap">
                                <div class="block_resources_start">
                                    <a class="img_1" href="{{ $resource->link('description') }}"
                                       title="Show {{ $resource->name }} description">
                                        <img class="" src="{{ $resource->getIconPath() }}"
                                             alt="{{ $resource->name }} logo" width="50" height="50">
                                    </a>
                                </div>
                                <div class="ms-sm-4">
                                    <h1 class="fw-bold fs-5 mb-0">{{ $resource->name }}</h1>
                                    <p class="fs-7">{{ $resource->tag }}</p>
                                </div>
                            </div>
                            @auth()
                                @if(user()->role->id == \App\Models\UserRole::BANNED)
                                    <div class="col-lg-3 col-xl-2 offset-lg-1">
                                        <div class="btn btn-primary w-100 rounded-1 cursor-disabled"
                                             title="{{ __('resources.download.access') }}">{{ $resource->price }}€
                                            <span class="fs-9 fw-light d-block">{{ $resource->fileInformations()['size'] }} .{{ $resource->fileInformations()['extension'] }}</span>
                                        </div>
                                    </div>
                                @elseif (user()->hasAccess($resource))
                                    <div class="col-lg-3 col-xl-2 offset-lg-1">
                                        <a href="{{  $resource->link('download') }}"
                                           class="btn btn-primary w-100 rounded-1">{{ __('resources.download.button') }}
                                            <span class="fs-9 fw-light d-block">{{ $resource->fileInformations()['size'] }} .{{ $resource->fileInformations()['extension'] }}</span>
                                        </a>
                                    </div>
                                @elseif(!$resource->canBePurchase())
                                    <div class="col-lg-3 col-xl-2 offset-lg-1">
                                        <div class="btn btn-primary w-100 rounded-1 disabled cursor-disabled"
                                           title="{{ __('resources.purchase.error', ['price' => $resource->price]) }}">{{ __('resources.purchase.button', ['price' => $resource->price]) }}
                                            <span class="fs-9 fw-light d-block">{{ $resource->fileInformations()['size'] }} .{{ $resource->fileInformations()['extension'] }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-lg-3 col-xl-2 offset-lg-1">
                                        <a class="btn btn-primary w-100 rounded-1"
                                           href="{{ $resource->link('purchase') }}"
                                           title="{{ __('resources.purchase.button', ['price' => $resource->price]) }}">{{ __('resources.purchase.button', ['price' => $resource->price]) }}
                                            <span class="fs-9 fw-light d-block">{{ $resource->fileInformations()['size'] }} .{{ $resource->fileInformations()['extension'] }}</span>
                                        </a>
                                    </div>
                                @endif
                            @endauth
                            @guest
                                <div class="col-lg-3 col-xl-2 offset-lg-1">
                                    <div class="btn btn-primary w-100 rounded-1 disabled cursor-disabled"
                                         title="{{ __('resources.download.login') }}">{{ __('resources.download.button') }}
                                        <span class="fs-9 fw-light d-block">{{ $resource->fileInformations()['size'] }} .{{ $resource->fileInformations()['extension'] }}</span>
                                    </div>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9">
                        <ul class="nav nav-tabs justify-content-lg-between flex-wrap flex-lg-nowrap" id="myTabResources"
                            role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link @if(isRoute('resources.view')) active @endif" id="overview-tab"
                                   href="{{ $resource->link('description') }}">{{ __('resources.overview') }}
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link @if(isRoute('resources.updates')) active @endif" id="update-tab"
                                   href="{{ $resource->link('updates') }}">{{ __('resources.update.title') }}
                                    ({{ $resource->countUpdates() }})
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link @if(isRoute('resources.reviews')) active @endif" id="notice-tab"
                                   href="{{ $resource->link('reviews') }}">{{ __('resources.reviews.title') }}
                                    ({{ $resource->countReviews() }})
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link @if(isRoute('resources.versions')) active @endif" id="history-tab"
                                   href="{{ $resource->link('versions') }}">{{ __('resources.versions.title') }}
                                </a>
                            </li>
                            <!--<li class="nav-item" role="presentation">
                                <a class="nav-link" id="discussions-tab" data-bs-toggle="tab"
                                   data-bs-target="#discussions-tab-pane" type="button" role="tab"
                                   aria-controls="discussions-tab-pane" aria-selected="false">Discussions
                                </a>
                            </li>-->
                            @auth()
                                @if ($resource->isModerator() && $resource->price != 0)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link @if(isRoute('resources.buyers')) active @endif"
                                           id="buyers-tab"
                                           href="{{ $resource->link('buyers') }}">{{ __('resources.buyers.title') }}
                                        </a>
                                    </li>
                                @endif
                            @endauth
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            @yield('resource')
                        </div>
                    </div>
                    <div class="col-lg-3 mt-3 mt-lg-0">

                        @include('resources.elements.sponsor')

                        @auth()
                            @if ($resource->isModerator())
                                <div class="card mb-3 rounded-1">
                                    <div class="card-body">
                                        <h2 class="text-center fs-6 fw-bold mb-3">{{ __('resources.tools') }}</h2>
                                        <a href="{{ route('resources.edit.index', ['resource' => $resource]) }}"
                                           class="text-decoration-none d-block">{{ __('resources.edit.content') }}</a>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#iconModal"
                                           class="text-decoration-none d-block">{{ __('resources.edit.icon') }}</a>
                                        <a href="{{ route('resources.update.index', ['resource' => $resource]) }}"
                                           class="text-decoration-none d-block">{{ __('resources.edit.update') }}</a>
                                        @if(user()->isAdmin())
                                        <a href="{{ $resource->link('purchase')  }}"
                                           class="text-decoration-none d-block">{{ __('resources.edit.purchase') }}</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal fade" id="iconModal" tabindex="-1" aria-labelledby="iconModalLabel"
                                     aria-hidden="true">
                                    <form method="post" enctype="multipart/form-data"
                                          action="{{ route('resources.icon', ['resource' => $resource]) }}">
                                        @csrf
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="exampleModalLabel">{{ __('resources.edit.icon_modal.title') }}</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <label class="form-check-label"
                                                           for="icon">{{ __('resources.create.image.name') }}</label>
                                                    <input type="file"
                                                           class="form-control rounded-1 mt-2 @error('icon') is-invalid @enderror"
                                                           name="icon"
                                                           id="icon" accept=".jpg,.jpeg,.png" required>
                                                    <small>{{ __('resources.create.image.description') }}</small>
                                                    @error('icon')
                                                    <div id="icon_error" class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary rounded-1 btn-sm"
                                                            data-bs-dismiss="modal">{{ __('messages.close') }}</button>
                                                    <button type="submit"
                                                            class="btn btn-primary rounded-1 btn-sm">{{ __('messages.save_changes') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endauth
                        @if($resource->discord_server_id != null)
                            <div class="card mb-3 rounded-1">
                                <div class="card-body">
                                    <a href="#" id="discord_server_id" target="_blank"
                                       data-url="{{ route('api.v1.discord.information', ['server_id' => $resource->discord_server_id]) }}">
                                        <img src="{{ asset('images/discord.svg') }}" alt="Discord logo">
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($resource->bstats_id != null)
                            <div class="card mb-3 rounded-1">
                                <div class="card-body">
                                    <h2 class="text-center fs-6 fw-bold mb-3">{{ __('messages.statistics') }}</h2>
                                    <ul class="list-group">
                                        <li class="d-flex justify-content-between align-items-center">
                                            {{ __('messages.bstats.players') }}
                                            <div id="bstats-players"
                                                 data-url="{{ route('api.v1.bstats.stats', ['id' => $resource->bstats_id, 'chart' => 'servers']) }}">
                                                <div class="spinner-border spinner-border-sm" role="status"><span
                                                        class="visually-hidden">Loading...</span></div>
                                            </div>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center">
                                            {{ __('messages.bstats.servers') }}
                                            <div id="bstats-servers"
                                                 data-url="{{ route('api.v1.bstats.stats', ['id' => $resource->bstats_id, 'chart' => 'players']) }}">
                                                <div class="spinner-border spinner-border-sm" role="status"><span
                                                        class="visually-hidden">Loading...</span></div>
                                            </div>
                                        </li>
                                        <li class="d-flex justify-content-end align-items-center">
                                            <span
                                                class="fs-7 text-secondary">{!! __('messages.bstats.more', ['url' => route('api.v1.bstats.url', ['id' => $resource->bstats_id])]) !!}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="card mb-3 rounded-1">
                            <div class="card-body">
                                <h2 class="text-center fs-6 fw-bold mb-3">{{ __('resources.informations') }}</h2>
                                <ul class="list-group">
                                    <li class="d-flex justify-content-between align-items-center">
                                        {{ __('messages.author') }} <span class="text-danger"><a
                                                href="{{ $resource->cache('user')->authorPage() }}">{{ $resource->cache('user')->name  }}</a></span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center">
                                        {{ __('messages.downloads') }}<span>{{ $resource->countDownload() }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center">
                                        {{ __('messages.first-release') }}
                                        <span>{{ format($resource->created_at) }}</span>
                                    <li class="d-flex justify-content-between align-items-center">
                                        {{ __('messages.last-update') }}
                                        <span>{{ format($resource->cache('version')->created_at) }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center">
                                        {{ __('messages.category') }}
                                        <span>{{ $resource->cache('category')->name }}</span>
                                    </li>

                                    <li class="d-flex justify-content-between align-items-center mt-4">
                                        {{ __('resources.review-all-time') }}
                                        <span>
                                            @auth
                                                @include('elements.stars', ['percentage' => $resource->startPercentage()])
                                            @endauth
                                            @guest
                                                @include('elements.stars-static', ['percentage' => $resource->startPercentage()])
                                            @endguest
                                            <br>
                                            <span
                                                class="text-muted fst-italic">({{ $resource->countReviews() }} {{ __('messages.reviews') }})</span>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card mb-3 rounded-1">
                            <div class="card-body">
                                <h2 class="text-center fs-6 fw-bold mb-3">{{ __('messages.version') }} {{ $resource->cache('version')->version }}</h2>
                                <ul class="list-group">
                                    <li class="d-flex justify-content-between align-items-center">
                                        {{ __('messages.version') }}
                                        <span>{{ $resource->cache('version')->version }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center">
                                        {{ __('messages.downloads') }}
                                        <span>{{ $resource->cache('version')->download }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center">
                                        {{ __('messages.updated') }}
                                        <span>{{ format($resource->cache('version')->created_at) }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center mt-4">
                                        {{ __('resources.review-current') }}
                                        <span>
                                            @auth
                                                @include('elements.stars', ['percentage' => $resource->cache('version')->startPercentage()])
                                            @endauth
                                            @guest
                                                @include('elements.stars-static', ['percentage' => $resource->cache('version')->startPercentage()])
                                            @endguest
                                        <br>
                                        <span
                                            class="text-muted fst-italic">({{ $resource->countReviews() }} {{ __('messages.reviews') }})</span>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('elements.review')
@endsection
