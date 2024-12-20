@extends('layouts.base')

@push('styles')
    @viteReactRefresh
    @vite(['resources/js/builder/builder.js'])
@endpush

@section('title', 'Inventory Builder')

@section('app')

    <div class="p-4">
        <div class="alert alert-warning" role="alert">
            <i class="bi bi-exclamation-diamond"></i> The Inventory Builder is currently under development. The site is on <a href="https://github.com/Maxlego08/Minecraft-Inventory-Builder" target="_blank">Github <i class="bi bi-github"></i></a>, if you want to participate to improve it do not hesitate !
        </div>
    </div>

    <div class="p-4 d-flex justify-content-center align-items-center flex-column">
        <a href="{{ route('builder.inventories') }}" class="btn btn-secondary mb-2">Inventory MarketPlace</a>
        <span>Discover the list of inventories of other users. Share your inventories by making them public !</span>
        <span>Use the <strong>/zmenu download [link]</strong> command to download inventories quickly !</span>
    </div>

    <div id="builder">
        <div class="builder">
        </div>
    </div>
    @include('builder.error')
@endsection
