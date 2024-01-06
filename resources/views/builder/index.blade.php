@extends('layouts.base')

@push('styles')
    @viteReactRefresh
    @vite(['resources/js/builder/builder.js'])
@endpush

@section('title', 'Inventory Builder')

@section('app')
<div id="builder">

</div>
@endsection
