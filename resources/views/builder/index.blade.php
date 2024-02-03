@extends('layouts.base')

@push('styles')
    @viteReactRefresh
    @vite(['resources/js/builder/builder.js'])
@endpush

@section('title', 'Inventory Builder')

@section('app')
    @if(user()->isAdmin())
<div id="builder">

</div>
    @else
        <h1>You do not yet have access to the online editor, it is in development.</h1>
    @endif
@endsection
