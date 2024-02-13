@extends('layouts.base')

@section('title', 'InventoryBuilder Builder')

@section('app')
    <div class="container p-5 d-flex flex-wrap">
        @foreach($items as $item)
            <div class="p-1 d-flex flex-column align-items-center justify-content-center m-2">
                <i class="icon-minecraft {{ $item->css }}"></i>
                <span>{{ $item->id }}</span>
            </div>
        @endforeach

    </div>
@endsection
