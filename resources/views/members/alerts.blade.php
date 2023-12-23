@extends('members.layouts.app')

@section('title', __('alerts.title'))

@section('content-member')

    <div class="card rounded-1 mt-3 mb-3">
        <div class="card-body">
            <h2>{{ __('alerts.title') }}</h2>

            <ul class="ps-0 ms-0 py-2 rounded-1" id="alerts">

                @foreach($alerts as $alert)

                    @if ($alert->target_id || $alert->translation_key || $alert->icon)

                        <li class="list-group-item list-group-item-{{ $alert->level }} rounded-0 mb-2 p-2">
                            <div class='d-flex'>
                                @if ($alert->target_id)
                                    <img src="{{ $alert->target->getProfilePhotoUrlAttribute() }}"
                                         height='50' width='50' alt='{{ $alert->target->name }} avatar'
                                         class='rounded-2'>
                                @else
                                    <i class="{!! $alert->icon !!} fs-2"></i>
                                @endif
                                <div class='ms-2'>
                                    <div>
                                        @if ($alert->translation_key)
                                            @if ($alert->target_id)
                                                {!! __($alert->translation_key, ['user' => "<a href='" . route('resources.author', ['user' => $alert->target, 'slug' => $alert->target->slug()]) ."'>{$alert->target->name}</a>", 'content' => "<a href='{$alert->link}'>{$alert->content}</a>"]) !!}
                                            @else
                                                @if (!$alert->link)
                                                    {!! __($alert->translation_key, ['user' => "#", 'content' => $alert->content]) !!}
                                                @else
                                                    {!! __($alert->translation_key, ['user' => "#", 'content' => "<a href='{$alert->link}'>{$alert->content}</a>"]) !!}
                                                @endif
                                            @endif
                                        @else
                                            {{ $alert->content }}
                                        @endif
                                    </div>
                                    <small>{{ format($alert->created_at) }}</small>
                                </div>
                            </div>
                        </li>

                    @else
                        <li class="list-group-item rounded-1 mb-2">
                            <div>{{ $alert->content }}</div>
                            <small>{{ format($alert->created_at) }}</small>
                        </li>
                    @endif

                @endforeach

            </ul>
        </div>
    </div>

@endsection
