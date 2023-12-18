@extends('members.layouts.app')

@section('title', __('colors.title'))

@section('content-member')

    <div class="mt-3">
        <div class="card rounded-1 mb-3">
            <div class="card-body">
                <h2 class="h3">{{ __('colors.title') }}</h2>
                <hr>
                <div class="d-flex justify-content-center h2">
                    {!! user()->displayNameAndLink() !!}
                </div>
                <hr>
                <ul class="list-group list-group-flush">
                    @foreach($colors as $color)
                        <li class="d-flex justify-content-between align-items-center ps-2 pe-2">
                            <span class="{{ $color->code }}">{{ __('colors.' . $color->code) }}</span>
                            @if(user()->name_color_id == $color->id)
                                <form action="{{ route('profile.colors.disable') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-sm btn-danger btn-sm"><i
                                            class="bi bi-trash me-2"></i>{{ __('colors.disable') }}</button>
                                </form>
                            @elseif(user()->hasNameAccess($color))
                                <form action="{{ route('profile.colors.store', ['nameColor' => $color->id]) }}"
                                      method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-sm btn-success btn-sm">{{ __('colors.enable') }}</button>
                                </form>
                            @else
                                <form action="{{ route('profile.colors.checkout', ['nameColor' => $color->id]) }}"
                                      method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success btn-sm"><i
                                            class="bi bi-cart me-2"></i>{{ __('colors.buy', ['price' => $color->price]) }}
                                    </button>
                                </form>
                            @endif
                        </li>
                        <hr>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

@endsection
