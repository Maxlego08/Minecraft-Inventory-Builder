@extends('layouts.base')

@push('styles')
    @viteReactRefresh
    @vite(['resources/js/builder/builder.js'])
@endpush

@section('title', 'Inventory Builder')

@section('app')
    <div class="p-4 d-flex justify-content-center align-items-center flex-column">
        <a href="{{ route('builder.inventories') }}" class="btn btn-secondary mb-2">Inventory Marketplace</a>
        <span>Discover the list of inventories from other users. Share your inventories by making them public!</span>
        <span>Use the <strong>/zmenu download [link]</strong> command to quickly download inventories!</span>
    </div>

    <a class="p-4 d-flex justify-content-center align-items-center flex-column" href="https://minestrator.com/a/GROUPEZ"
       target="_blank"
       title="Open minestrator website"
       style="color: white; text-decoration: none;"
    >
        <h4>
            <img src="/images/s.svg" alt="Minestrator Logo" width="32" height="32"/>
            <span>MineStrator, leading Minecraft server host for years!</span>
        </h4>
        <span>Get <strong>10%</strong> discount on your purchases with the code GROUPEZ !</span>
        <span>By clicking the button below, you support GROUPEZ and get an unbeatable discount</span>
    </a>

    <div id="builder">
        <div class="builder"></div>
    </div>
    @include('builder.error')
@endsection
