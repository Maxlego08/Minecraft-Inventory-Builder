@extends('members.layouts.app')

@section('title', __('alerts.title'))

@section('content-member')

    <div class="card rounded-0 mt-3 mb-3">
        <div class="card-body">
            <h2>{{ __('alerts.title') }}</h2>

            <ul class="ps-0 ms-0 py-2 rounded-0" id="alerts">

                @foreach($alerts as $alert)

                    @if ($alert->target_id || $alert->translation_key || $alert->icon)

                        <li class="list-group-item rounded-0 mb-2">
                            <div class='d-flex'>
                                @if ($alert->target_id)
                                    <img src="{{ $alert->target->getProfilePhotoUrlAttribute() }}"
                                         height='50' width='50' alt='{{ $alert->target->name }} avatar' class='rounded-2'>
                                @else
                                    {!! $alert->icon !!}
                                @endif
                                <div class='ms-2'>
                                    <div>
                                        @if ($alert->translation_key)
                                            {!! __($alert->translation_key, ['user' => "<a href='/profile/'{$alert->target->name}>{$alert->target->name}</a>", 'content' => "<a href='{$alert->link}'>{$alert->content}</a>"]) !!}
                                        @else
                                            {{ $alert->content }}
                                        @endif
                                    </div>
                                    <small>{{ format($alert->created_at) }}</small>
                                </div>
                            </div>
                        </li>

                    @else
                        <li class="list-group-item rounded-0 mb-2">
                            <div>{{ $alert->content }}</div>
                            <small>{{ format($alert->created_at) }}</small>
                        </li>
                    @endif

                @endforeach

            </ul>
        </div>
    </div>

@endsection