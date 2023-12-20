@php use Illuminate\Support\Str; @endphp
@extends('resources.layouts.dashboard')

@section('title', __('resources.dashboard.discord.title'))

@section('dashboard-section')

    <div class="card rounded-1">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h3>{{ __('resources.dashboard.discord.title') }}</h3>
                <a class="h3 text-success" href="{{ route('resources.dashboard.discord.create') }}"><i class="bi bi-plus-circle"></i></a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th style="width: 25px"></th>
                        <th>{{ __('resources.dashboard.discord.table.url') }}</th>
                        <th class="text-center">{{ __('resources.dashboard.discord.table.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($discords as $discord)
                        <tr>
                            <td>
                                @if($discord->is_valid)
                                    <i class="bi bi-check-lg text-success"></i>
                                @else
                                    <i class="bi bi-x-lg text-danger"></i>
                                @endif
                            </td>
                            <td>{{ Str::limit($discord->url, 75) }}</td>
                            <td class="d-flex justify-content-evenly align-items-center">
                                <a href="{{ route('resources.dashboard.discord.edit', $discord) }}"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('resources.dashboard.discord.delete', $discord) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn" style="background: none; border: none; padding: 0;" aria-label="Submit">
                                        <i class="bi bi-trash text-danger"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

