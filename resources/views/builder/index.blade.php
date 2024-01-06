@extends('layouts.base')

@push('styles')
    @vite(['resources/js/builder/builder.js'])
@endpush

@section('title', 'Inventory Builder')

<div id="builder">

</div>

@section('app')
@endsection
