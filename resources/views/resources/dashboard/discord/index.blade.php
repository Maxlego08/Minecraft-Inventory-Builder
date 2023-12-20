@php use Illuminate\Support\Str; @endphp
@extends('resources.layouts.dashboard')

@section('title', __('resources.dashboard.discord.title'))

@section('dashboard-section')

    <div class="card rounded-1 mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h3>{{ __('resources.dashboard.discord.title') }}</h3>
                <a class="h3 text-success" href="{{ route('resources.dashboard.discord.create') }}"
                   title="{{ __('resources.dashboard.discord.table.create') }}"><i class="bi bi-plus-circle"></i></a>
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
                                <a href="{{ route('resources.dashboard.discord.edit', $discord) }}"
                                   title="{{ __('resources.dashboard.discord.table.edit') }}"><i
                                        class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('resources.dashboard.discord.delete', $discord) }}" method="POST"
                                      title="{{ __('resources.dashboard.discord.table.delete') }}">
                                    @csrf
                                    <button type="submit" class="btn"
                                            style="background: none; border: none; padding: 0;" aria-label="Submit">
                                        <i class="bi bi-trash text-danger"></i>
                                    </button>
                                </form>
                                <form action="{{ route('resources.dashboard.discord.test', $discord) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn"
                                            style="background: none; border: none; padding: 0;" aria-label="Submit"
                                            title="{{ __('resources.dashboard.discord.table.test') }}">
                                        <i class="bi bi-send text-warning" title="Send a test"></i>
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

    <div class="card rounded-1 mb-3">
        <div class="card-body">
            <h3>{{ __('resources.dashboard.discord.documentation.events') }}</h3>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="w-25">{{ __('resources.dashboard.discord.documentation.events') }}</th>
                        <th>{{ __('resources.dashboard.discord.documentation.description') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>{{ $event }}</td>
                            <td>{{ __("resources.dashboard.discord.documentation." . str_replace('.', '_', $event)) }}.</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card rounded-1">
        <div class="card-body">
            <h3>{{ __('resources.dashboard.discord.documentation.variable') }}</h3>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="w-25">{{ __('resources.dashboard.discord.documentation.variable') }}</th>
                        <th>{{ __('resources.dashboard.discord.documentation.description') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($variables as $variable)
                        <tr>
                            <td>{<span>{{ $variable }}</span>}</td>
                            <td>{{ __("resources.dashboard.discord.documentation.$variable") }}.</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

