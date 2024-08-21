@extends('members.layouts.app')

@section('title', __('colors.title'))

@section('content-member')

    <div class="mt-3">
        <div class="card rounded-1 mb-3">
            <div class="card-body">
                <h2 class="h3">{{ __('colors.title') }}</h2>
                <hr>
                <div class="d-flex justify-content-center h2">
                    {!! user()->displayNameAndLink(true, 'user-name') !!}
                </div>
                <hr>

                <div class="d-flex flex-wrap mb-5 justify-content-center">
                    @foreach($colors as $color)
                        <div class="username-card">
                            @if(user()->name_color_id == $color->id)
                                <i class="bi bi-trash me-2 text-danger"></i>
                            @elseif(user()->hasNameAccess($color))
                                <i class="bi bi-check-lg text-success"></i>
                            @else
                                <i class="bi bi-cart me-2 text-warning"></i>
                            @endif
                            <span class="username-card-content {{ $color->code }}"
                                  data-toggle="{{ user()->name_color_id === $color->id }}"
                                  data-access="{{ user()->hasNameAccess($color) }}"
                                  @if(user()->name_color_id == $color->id)
                                      data-translation="{{ __('colors.disable') }}"
                                  data-url="{{ route('profile.colors.disable') }}"
                                  @elseif(user()->hasNameAccess($color))
                                      data-translation="{{ __('colors.enable') }}"
                                  data-url="{{ route('profile.colors.store', ['nameColor' => $color->id]) }}"
                                  @else
                                      data-translation="{{ __('colors.buy', ['price' => $color->getPrice()]) }}"
                                  data-url="{{ route('profile.colors.checkout', ['nameColor' => $color->id]) }}"
                                  @endif
                                  data-csrf="{{ csrf_token() }}"
                            >{{ __('colors.' . $color->code) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
