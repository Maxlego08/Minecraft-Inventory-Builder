@extends('layouts.base')

@push('styles')
    @viteReactRefresh
    @vite(['resources/js/builder/builder.js'])
@endpush

@section('title', 'Inventory Builder')

@section('app')
    <div class="p-4">
        <div class="alert alert-warning" role="alert">
            <i class="bi bi-exclamation-diamond"></i> The Inventory Builder is currently under development. The site is on <a href="https://github.com/Maxlego08/Minecraft-Inventory-Builder" target="_blank">GitHub <i class="bi bi-github"></i></a>. If you want to participate in improving it, do not hesitate!
        </div>
    </div>

    <div class="p-4 d-flex justify-content-center align-items-center flex-column">
        <a href="{{ route('builder.inventories') }}" class="btn btn-secondary mb-2">Inventory Marketplace</a>
        <span>Discover the list of inventories from other users. Share your inventories by making them public!</span>
        <span>Use the <strong>/zmenu download [link]</strong> command to quickly download inventories!</span>
    </div>

    <div id="builder">
        <div class="builder"></div>
    </div>
    @include('builder.error')
@endsection
