@extends('layouts.base')

@section('title', 'GroupeZ')

@section('app')
    <div class="content_resources_show py-5 mb-5">
        <div class="container">
            <div class="px-3 px-lg-0">
                <div class="card my-4 rounded-0">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-7 col-xl-9 d-flex align-items-center flex-wrap flex-sm-nowrap">
                                <div class="block_resources_start">
                                    <a class="img_1" href="{{ $resource->link('description') }}"
                                       title="Show {{ $resource->name }} description">
                                        <img class="" src="{{ $resource->icon->getPath() }}"
                                             alt="{{ $resource->name }} logo" width="50" height="50">
                                    </a>
                                </div>
                                <div class="ms-sm-4">
                                    <h1 class="fw-bold fs-5 mb-0">{{ $resource->name }}</h1>
                                    <p>{{ $resource->tag }}</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xl-2 offset-lg-1">
                                <a href="{{  url('resources.buy') }}" class="btn btn-primary w-100 rounded-0">TÉLÉCHARGER<span
                                        class="fs-7 fw-light d-block">809.6 KB .jar</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-9">
                        <ul class="nav nav-tabs justify-content-lg-between flex-wrap flex-lg-nowrap" id="myTabResources"
                            role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="overview-tab" data-bs-toggle="tab"
                                   data-bs-target="#overview-tab-pane" type="button" role="tab"
                                   aria-controls="home-tab-pane" aria-selected="true">Aperçu
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="update-tab" data-bs-toggle="tab"
                                   data-bs-target="#update-tab-pane" type="button" role="tab"
                                   aria-controls="update-tab-pane" aria-selected="false">Mise à jour (43)
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="notice-tab" data-bs-toggle="tab"
                                   data-bs-target="#notice-tab-pane" type="button" role="tab"
                                   aria-controls="notice-tab-pane" aria-selected="false">Avis (17)
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="history-tab" data-bs-toggle="tab"
                                   data-bs-target="#history-tab-pane" type="button" role="tab"
                                   aria-controls="history-tab-pane" aria-selected="false">Historique
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="discussions-tab" data-bs-toggle="tab"
                                   data-bs-target="#discussions-tab-pane" type="button" role="tab"
                                   aria-controls="discussions-tab-pane" aria-selected="false">Discussions
                                </a>
                            </li>
                            @if ($resource->isModerator())
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="buyers-tab" data-bs-toggle="tab"
                                       data-bs-target="#buyers-tab-pane" type="button" role="tab"
                                       aria-controls="buyers-tab-pane"
                                       aria-selected="false">{{ __('resources.buyers') }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="bg-blue-800 p-4 show active">
                                @yield('resource')
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 mt-3 mt-lg-0">

                        @if($resource->discord_server_id != null)
                            <div class="card mb-3 rounded-0">
                                <div class="card-body">
                                    <a href="#" id="discord_server_id" target="_blank"
                                       data-url="{{ route('api.v1.discord.information', ['server_id' => $resource->discord_server_id]) }}">
                                        <img src="{{ asset('images/discord.svg') }}" alt="Discord logo">
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($resource->bstats_id != null)
                            <div class="card mb-3 rounded-0">
                                <div class="card-body">
                                    <h2 class="text-center fs-6 fw-bold mb-3">{{ __('messages.statistics') }}</h2>
                                    <ul class="list-group">
                                        <li class="d-flex justify-content-between align-items-center">
                                            {{ __('messages.bstats.players') }}
                                            <div id="bstats-players"
                                                 data-url="{{ route('api.v1.bstats.stats', ['id' => $resource->bstats_id, 'chart' => 'servers']) }}">
                                                <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>
                                            </div>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center">
                                            {{ __('messages.bstats.servers') }} <div id="bstats-servers"
                                                                                      data-url="{{ route('api.v1.bstats.stats', ['id' => $resource->bstats_id, 'chart' => 'players']) }}">
                                                <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>
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

                        <div class="card mb-3 rounded-0">
                            <div class="card-body">
                                <h2 class="text-center fs-6 fw-bold mb-3">{{ __('resources.informations') }}</h2>
                                <ul class="list-group">
                                    <li class="d-flex justify-content-between align-items-center">
                                        {{ __('messages.author') }} <span class="text-danger"><a
                                                href="{{ $resource->user->authorPage() }}">{{ $resource->user->name  }}</a></span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center">
                                        {{ __('messages.downloads') }}<span>{{ $resource->countDownload() }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center">
                                        {{ __('messages.first-release') }}
                                        <span>{{ format($resource->created_at) }}</span>
                                    <li class="d-flex justify-content-between align-items-center">
                                        {{ __('messages.last-update') }}
                                        <span>{{ format($resource->version->created_at) }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center">
                                        {{ __('messages.category') }}<span>{{ $resource->category->name }}</span>
                                    </li>

                                    <li class="d-flex justify-content-between align-items-center mt-4">
                                        {{ __('resources.review-all-time') }}
                                        <span>
                                            <span class="text-warning">
                                                {!! $resource->reviewScore() !!}
                                            </span>
                                            <br>
                                            <span
                                                class="text-muted fst-italic">({{ $resource->countReviews() }} {{ __('messages.reviews') }})</span>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card mb-3 rounded-0">
                            <div class="card-body">
                                <h2 class="text-center fs-6 fw-bold mb-3">{{ __('messages.version') }} {{ $resource->version->version }}</h2>
                                <ul class="list-group">
                                    <li class="d-flex justify-content-between align-items-center">
                                        {{ __('messages.version') }}<span>{{ $resource->version->version }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center">
                                        {{ __('messages.downloads') }}<span>{{ $resource->version->download }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center">
                                        {{ __('messages.updated') }}
                                        <span>{{ format($resource->version->created_at) }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center mt-4">
                                        {{ __('resources.review-current') }}
                                        <span>
                                            <span class="text-warning">
                                                {!! $resource->reviewScore() !!}
                                            </span>
                                        <br>
                                        <span
                                            class="text-muted fst-italic">({{ $resource->countReviews() }} {{ __('messages.reviews') }})</span>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card mb-3 rounded-0">
                            <div class="card-body">
                                <h2 class="text-center fs-6 fw-bold mb-3">{{ __('resources.tools') }}</h2>
                                <a href="{{ url('resources.edit', 1) }}"
                                   class="text-decoration-none d-block">{{ __('resources.edit.content') }}</a>
                                <a href="#" class="text-decoration-none d-block">{{ __('resources.edit.icon') }}</a>
                                <a href="{{ url('resources.update-ressource', 1) }}"
                                   class="text-decoration-none d-block">{{ __('resources.edit.update') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
