@extends('resources.layouts.dashboard')

@section('title', __('resources.dashboard.discord.create'))

@section('dashboard-section')

    <div class="card rounded-1">
        <div class="card-body">

            <form action="{{ route('resources.dashboard.discord.store') }}" method="POST">
                @csrf

                @include('resources.dashboard.discord._form')

                <button class="btn btn-success btn-primary w-100 rounded-1">{{ __('messages.save') }}</button>
            </form>

        </div>
    </div>

@endsection
